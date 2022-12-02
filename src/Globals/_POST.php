<?php

namespace App\Globals;

class _POST
{
    /**
     * @param string $key
     * @return string
     */
    public static function _POST(string $key): string
    {
        if (isset($_POST[$key])) {
            return strip_tags($_POST[$key]);
        }
        return '';
    }


    /**
     * @param string $key
     * @return bool
     */
    public static function isPost(string $key): bool
    {
        return isset($_POST[$key]);
    }
}