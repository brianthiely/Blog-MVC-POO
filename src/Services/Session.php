<?php
declare(strict_types=1);

namespace App\Services;

class Session {
    /**
     * Start the session
     *
     * @return void
     */
    public static function start(): void
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (self::isExpired()) {
            self::destroy();
        } else {
            self::renew();
        }
    }

    /**
     * Check if the session has expired
     *
     * @return bool
     */
    private static function isExpired(): bool
    {
        return isset($_SESSION['expiration']) && time() > $_SESSION['expiration'];
    }

    /**
     * Renew the session
     *
     * @return void
     */
    private static function renew(): void
    {
        $_SESSION['id'] = uniqid();
        $_SESSION['expiration'] = time() + 1800;
    }


    /**
     * Set a session variable
     *
     * @param string $key The key of the session variable
     * @param mixed $value
     * @return void
     */
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Get a session variable
     *
     * @param string $key1 The key of the session variable
     * @param string|null $key2 The key of the session variable
     * @return mixed
     */
    public static function get(string $key1, ?string $key2 = null): mixed {
        // Check if the specified key exists in the session variable
        if (!isset($_SESSION[$key1])) {
            // If not, return null
            return null;
        }

        $value = $_SESSION[$key1];

        if ($key2 === null) {
            return $value;
        }

        // If the value is an object, check if it has a getter or setter for the specified sub-key
        if (is_object($value)) {
            $getter = 'get' . ucfirst($key2);
            // Check if the object has a getter for the specified sub-key
            if (method_exists($value, $getter)) {
                // Yes, return the value of the getter
                return $value->$getter();
            }

            $setter = 'set' . ucfirst($key2);
            // Check if the object has a setter for the specified sub-key
            if (method_exists($value, $setter)) {
                // Yes, return the value of the setter
                return $value->$setter();
            }
        }
        // If the value is an array, return the value associated with the sub-key
        elseif (is_array($value)) {
            return $value[$key2];
        }
        // If none of the previous conditions are met, return null
        return null;
    }


    /**
     * Delete a session variable
     *
     * @return void
     */
    public static function destroy(): void
    {
        session_destroy();
    }
}
