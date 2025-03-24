<?php

namespace App\Infrastructure\Config;

class Config
{
    public static function get($key)
    {
        return $_ENV[$key] ?? null;
    }
}