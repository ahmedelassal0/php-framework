<?php
declare(strict_types=1);

namespace Core;
class Validator
{
    public static function string($string, $min = 1, $max = INF): bool
    {
        return strlen($string) >= $min && strlen($string) <= 1000;
    }

    public static function email($email): bool|string
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}