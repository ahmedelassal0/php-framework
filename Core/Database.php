<?php
declare(strict_types=1);

namespace Core;

use PDO;
class Database
{
    protected PDO $connection;
    protected \PDOStatement $statement;
    public function __construct(array $config, string $username = 'root', string $password = '')
    {
        $configQuery = http_build_query($config, arg_separator: ';');
        $dsn = "mysql:$configQuery";
        $this->connection =
            new PDO($dsn, $username, $password, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);  // dsn => data source name
    }

    function query(string $queryString, array $params = []) : static
    {

        $this->statement = $this->connection->prepare($queryString);
        $this->statement->execute($params);
        return $this;
    }

    public function find() : array|bool
    {
        return $this->statement->fetch();
    }

    public function findOrFail():array|bool
    {
        $result = $this->find();
        if(!$result) abort();
        return $result;
    }

    public function get(): array
    {
        return $this->statement->fetchAll();
    }

    public function rowCount(): int
    {
        return $this->statement->rowCount();
    }
}