<?php

namespace Http;

use Core\Validator;

class RegisterFrom
{
    protected array $errors = [];
    public function validate($email, $password)
    {
        if (!Validator::email($email)) {
            $this->errors['email'] = 'this is not a valid email';
        }

        if (!Validator::string($password)) {
            $this->errors['password'] = 'passwords are between 8 characters and 255 characters';
        }

        return empty($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }
}