<?php

use Core\App;
use Core\Database;
use Core\Response;
use Http\Session;

function dd($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
    die();
}

function uriIs($uri): bool
{
    return $_SERVER['REQUEST_URI'] === $uri;
}

function authorize($condition, $status = Response::FORBIDDEN)
{
    if (!$condition) abort($status); // unauthorized
}

function abort($code = 404): void
{
    http_response_code($code);
    view("$code.php");
    die();
}

function basePath(string $uri): string
{
    return __DIR__ . DIRECTORY_SEPARATOR . $uri;
}

function view(string $viewPath, array $attributes = []): void
{
    extract($attributes);
    require basePath('views' . DIRECTORY_SEPARATOR . $viewPath);
}

function redirect($path): void
{
    header("Location: $path");
    die();
}

function old(string $key): array|string
{
        return Session::getFromFlash('old')[$key] ?? '';
}

function user()
{
    return App::resolve(Database::class)
        ->query('SELECT * FROM users WHERE email = :email', [
            ':email' => $_SESSION['user']['email']
        ])->find();

}