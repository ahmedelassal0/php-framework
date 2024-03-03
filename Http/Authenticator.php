<?php

namespace Http;

use Core\App;
use Core\Database;

class Authenticator
{
    protected array $errors = [];

    public function attempt($email, $password): bool
    {
        $user = App::resolve(Database::class)
            ->query('SELECT * FROM users WHERE email = :email', [
                ':email' => $email
            ])->find();

        if (!$user || !password_verify($password, $user['password'])) {
            $this->errors['error'] = 'email or password are wrong';
            return false;
        }



        static::login([
            'id' => $user['id'],
            'email' => $email
        ]);
        return true;
    }

    public static function login($user): void
    {
        $_SESSION['user'] = $user;
        session_regenerate_id(true);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public static function logout(): void
    {
        // clear session from browser
        $_SESSION = [];

        session_destroy();

        $conf = session_get_cookie_params();

        setcookie(
            'PHPSESSID', '', time() - 3600,
            $conf['path'], $conf['domain'],
            $conf['secure'], $conf['httponly']
        );
    }
}