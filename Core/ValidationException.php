<?php

namespace Core;

class ValidationException extends \Exception
{
    public readonly array $errors;
    public readonly array $old;
    public $message = 'Validation failed';

    public static function throw($errors = [], $old = [])
    {
        $instance = new static();

        $instance->errors = $errors;
        $instance->old = $old;

        throw $instance;
    }
}