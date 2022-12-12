<?php
declare(strict_types=1);

namespace App\Models;

use Exception;

class Session
{
    private mixed $token;

    /**
     * @throws Exception
     */
    public function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (empty($_SESSION['token'])) {
            $this->generateToken();
        } else {
            $this->token = $_SESSION['token'];
        }
    }

    /**
     * @throws Exception
     */
    public function generateToken(): void
    {
        $this->token = bin2hex(random_bytes(32));
        $_SESSION['token'] = $this->token;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return void
     */
    public function destroy(): void
    {
        session_destroy();
    }


}
