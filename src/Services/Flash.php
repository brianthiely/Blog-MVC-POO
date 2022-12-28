<?php
declare(strict_types=1);


namespace App\Services;

class Flash
{
    /**
     * Set a flash message
     *
     * @param string $key The key of the message
     * @param string $value The value of the message
     */
    public static function set(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Verify if a flash message exists
     *
     * @param string $key The key of the message
     * @return bool True if the message exists, false otherwise
     */
    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Return a flash message
     *
     * @param string $key The key of the message
     * @return string|null The message or null if it doesn't exist
     */
    public static function get(string $key): ?string
    {
        if (self::has($key)) {
            $value = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $value;
        }
        return null;
    }
}
