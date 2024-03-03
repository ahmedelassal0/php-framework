<?php

namespace Core\Middleware;

class Guest
{
    public function handle(): void
    {
        if (!is_null($_SESSION['user'])) {
            header('Location: /');
            die();
        }
    }
}