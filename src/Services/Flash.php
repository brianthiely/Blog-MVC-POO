<?php
declare(strict_types=1);


namespace App\Services;

class Flash
{
    /**
     * Enregistre un message flash
     *
     * @param string $key
     * @param string $value
     */
    public static function set(string $key, string $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Vérifie si un message flash existe
     *
     * @param string $key
     * @return bool
     */
    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Récupère un message flash
     *
     * @param string $key
     * @return string|null
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
