<?php

namespace Http;

use Core\ValidationException;
use Core\Validator;

class LoginFrom
{
    protected array $errors = [];

    public function __construct(private $attributes)
    {
        if (!Validator::email($attributes['email'])
            ||
            !Validator::string($attributes['password'], 7)
        ) {
            $this->errors['error'] = 'wrong email or password';
        }

        return $this;
    }

    public static function validate($attributes): static
    {
        $instance = new static($attributes);
        if (!$instance->valid())
            ValidationException::throw($instance->errors(), ['email' => $attributes['email']]);

        return $instance;
    }

    public function valid(): bool
    {
        return empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }

    public function error($key, $value)
    {
        $this->errors[$key] = $value;
        return $this;
    }
    public function throw()
    {
        ValidationException::throw($this->errors(), $this->attributes);
    }
}