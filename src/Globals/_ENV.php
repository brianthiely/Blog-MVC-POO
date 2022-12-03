<?php

namespace App\Globals;

class _ENV
{
    /**
     * @param string $key
     * @return string
     */
    public static function getEnv(string $key): string
    {
        return $_ENV[$key];
    }

    /**
     * @param string $key
     * @return bool
     */
    public static function isEnv(string $key): bool
    {
        return isset($_ENV[$key]);
    }
}