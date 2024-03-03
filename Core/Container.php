<?php

namespace Core;

class Container
{
    protected $bindings = [];

    public function bind(string $key, callable $resolver)
    {
        $this->bindings[$key] = $resolver;
    }

    public function resolve($key): mixed
    {
        if (!array_key_exists($key, $this->bindings))
            throw new \Exception("container key {$key} does not exist");
        return call_user_func($this->bindings[$key]);
    }
}