<?php
declare(strict_types=1);

namespace Http;

class Session
{
    public static function has($value): bool
    {
        return (bool)static::get($value);
    }

    public static function set($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get($value): mixed
    {
        return $_SESSION[$value];
    }

    public static function flash(string $key, array $value): void
    {
        $_SESSION['_flash'][$key] = $value;
    }

    public static function unflash(): void
    {
        unset($_SESSION['_flash']);
    }

    public static function getFromFlash($key): mixed
    {
        return static::get('_flash')[$key];
    }

    public static function destroy()
    {
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