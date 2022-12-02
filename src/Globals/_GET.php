<?php

namespace App\Globals;

class _GET
{
    /**
     * @param string $key
     * @return string
     */
    public static function _GET(string $key): string
    {
        return $_GET[$key];
    }

    /**
     * @param string $key
     * @return bool
     */
    public static function isGet(string $key): bool
    {
        return isset($_GET[$key]);
    }

}