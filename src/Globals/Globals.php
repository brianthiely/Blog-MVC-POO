<?php

namespace App\Globals;

class Globals
{
    private string|array|false $GET;
    private string|array|false $SERVER;
    private string|array|false $POST;
    private string|array|false $ENV;
    private string|array $SESSION;

    public function __construct()
    {
        $this->GET = filter_input_array(INPUT_GET) ?? '';
        $this->SERVER = filter_input_array(INPUT_SERVER) ?? '';
        $this->POST = filter_input_array(INPUT_POST) ??'';
        $this->ENV = $_ENV ?? '';
        $this->SESSION = $_SESSION ?? '';
    }

    /**
     * @param $key
     * @return string|array|false|null
     */
    public function getGET($key = null): string|array|false|null
    {
        if (null !== $key) {
            return $this->GET[$key] ?? null;
        }
        return $this->GET;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function isGet(string $key): bool
    {
        return isset($this->GET[$key]);
    }

    /**
     * @param string|null $key
     */
    public function getServer(string $key = null)
    {
        if (null !== $key) {
            return $this->SERVER[$key] ?? null;
        }
        return $this->SERVER;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function isServer(string $key): bool
    {
        return isset($this->SERVER[$key]);
    }

    /**
     * @param string|null $key
     * @return string|array|false|null
     */
    public function getPost(string $key =  null): bool|array|string|null
    {
        if (null !== $key) {
            return $this->POST[$key] ?? '';
        }
        return $this->POST;
    }
    /**
     * @param string $key
     * @return bool
     */
    public function isPost(string $key): bool
    {
        return isset($this->POST[$key]);
    }

    // Recuperer la variable d'environnement du fichier .env
    /**
     * @param string $key
     * @return string
     */
    public function getEnv(string $key): string
    {
        return $this->ENV[$key] ?? '';
    }


    /**
     * @param string $key
     * @return bool
     */
    public function isEnv(string $key): bool
    {
        return isset($this->ENV[$key]);
    }

    /**
     * @param string|null $key
     * @return string|array
     */
    public function getSession(string $key = null): string|array
    {
        if (null !== $key) {
            return $this->SESSION[$key] ?? '';
        }
        return $this->SESSION;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function isSession(string $key): bool
    {
        return isset($this->SESSION[$key]);
    }

    /**
     * @param string|null $key
     * @param string|null $value
     */
    public function setSession(string $key = null, string $value = null ): array|string
    {
        if (null !== $key && null !== $value) {
             return $this->SESSION[$key] = $value;
        }
        return $this->SESSION;
    }

    /**
     * @param string $key
     * @return void
     */
    public function unsetSession(string $key): void
    {
        unset($this->SESSION[$key]);
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->getServer('REQUEST_URI');
    }
}