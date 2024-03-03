<?php

namespace Core;

use Core\Middleware\Middleware;

class Router
{
    protected array $routes = [];

    protected function register($uri, $controller, $method): Router
    {
        $this->routes [] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middleware' => null
        ];

        return $this;
    }

    public function get($uri, $controller)
    {
        return $this->register($uri, $controller, 'GET');

    }

    public function post($uri, $controller)
    {
        return $this->register($uri, $controller, 'POST');

    }

    public function patch($uri, $controller)
    {
        return $this->register($uri, $controller, 'PATCH');

    }

    public function put($uri, $controller)
    {
        return $this->register($uri, $controller, 'PUT');

    }

    public function delete($uri, $controller)
    {
        return $this->register($uri, $controller, 'DELETE');


    }

    public function route(string $uri, string $method)
    {
        foreach ($this->routes as $route) {
            if ($uri === $route['uri'] && strtoupper($method) === strtoupper($route['method'])) {
                Middleware::resolve($route['middleware']);
                return require basePath("controllers/{$route['controller']}");
            }
        }
        $this->abort();
    }

    public function only($key)
    {
        $this->routes
        [array_key_last($this->routes)]
        ['middleware'] = $key;
    }

    protected function abort($code = 404): void
    {
        http_response_code($code);
        view("$code.php");
        die();
    }
}