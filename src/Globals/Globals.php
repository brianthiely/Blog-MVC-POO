<?php
declare(strict_types=1);
namespace App\Globals;

class Globals
{
    private string|array|false $GET;
    private string|array|false $SERVER;
    private string|array|false $POST;
    private string|array|false $ENV;

    public function __construct()
    {
        $this->GET = filter_input_array(INPUT_GET) ?? '';
        $this->SERVER = filter_input_array(INPUT_SERVER) ?? '';
        $this->POST = filter_input_array(INPUT_POST) ??'';
        $this->ENV = $_ENV ?? '';
    }

    /**
     * Get the value of the "GET" array, or a specific element of the array if a key is specified.
     *
     * @param string|null $key The key of the element to get.
     * @return string|array|false|null The value of the "GET" array, a specific element of the array, or null if the element is not set.
     */
    public function getGET(string $key = null): string|array|false|null
    {
        if (null !== $key) {
            return $this->GET[$key] ?? null;
        }
        return $this->GET;
    }

    /**
     * Check if an element with the specified key exists in the "GET" array.
     *
     * @param string $key The key to check for.
     * @return bool True if the element exists, false otherwise.
     */
    public function isGet(string $key): bool
    {
        return isset($this->GET[$key]);
    }

    /**
     * Get the value of the "SERVER" array, or a specific element of the array if a key is specified.
     *
     * @param string|null $key The key of the element to get.
     * @return string|array|false|null The value of the "SERVER" array, a specific element of the array, or null if the element is not set.
     */
    public function getServer(string $key = null): bool|array|string|null
    {
        if (null !== $key) {
            return $this->SERVER[$key] ?? null;
        }
        return $this->SERVER;
    }

    /**
     * Check if an element with the specified key exists in the "SERVER" array.
     *
     * @param string $key The key to check for.
     * @return bool True if the element exists, false otherwise.
     */
    public function isServer(string $key): bool
    {
        return isset($this->SERVER[$key]);
    }

    /**
     * Get the value of the "POST" array, or a specific element of the array if a key is specified.
     *
     * @param string|null $key The key of the element to get.
     * @return bool|array|string|int|null The value of the "POST" array, a specific element of the array, or an empty string if the element is not set.
     */
    public function getPost(string $key =  null): bool|array|string|int|null
    {
        if (null !== $key) {
            return $this->POST[$key] ?? '';
        }
        return $this->POST;
    }

    /**
     * Check if an element with the specified key exists in the "POST" array.
     *
     * @param string $key The key to check for.
     * @return bool True if the element exists, false otherwise.
     */
    public function isPost(string $key): bool
    {
        return isset($this->POST[$key]);
    }

    /**
     * Get the value of an element in the "ENV" array.
     *
     * @param string $key The key of the element to get.
     * @return string The value of the element, or an empty string if the element is not set.
     */
    public function getEnv(string $key): string
    {
        return $this->ENV[$key] ?? '';
    }

    /**
     * Get the value of the "REQUEST_URI" element in the "SERVER" array.
     *
     * @return string The value of the "REQUEST_URI" element.
     */
    public function getUri(): string
    {
        return $this->getServer('REQUEST_URI');
    }
}
