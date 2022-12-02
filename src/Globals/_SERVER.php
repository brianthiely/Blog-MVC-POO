<?php

namespace App\Globals;

class _SERVER
{
    /**
     * @return string
     */
    public function getUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }
}