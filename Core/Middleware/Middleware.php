<?php

namespace Core\Middleware;

class Middleware
{
    /**
     * lookup table
     * middleware name => middleware controller
     **/
    const MAP = [
        'auth' => Auth::class,
        'guest' => Guest::class
    ];

    public static function resolve($name)
    {
        if ($name === null) return;

        if (array_key_exists($name, static::MAP)) {
            $middleware = Middleware::MAP[$name];
            (new $middleware())->handle();
        }
    }
}