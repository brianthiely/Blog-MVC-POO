<?php
declare(strict_types=1);

namespace App\Globals;

class _SESSION
{
    /**
     * @param string $key
     * @param string $value
     * @return void
     */
    public static function setSession(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
        if ($key === 'errors' || $key === 'message') {
            unset($_SESSION[$key]);
        }
    }

    /**
     * @param string $key
     * @return string
     */
    public static function getSession(string $key): string
    {
        return $_SESSION[$key][$key];
    }

    /**
     * @param string $key
     * @return bool
     */
    public static function isSession(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * @param string $key
     * @return void
     */
    public static function unsetSession(string $key): void
    {
        unset($_SESSION[$key]);
    }
}