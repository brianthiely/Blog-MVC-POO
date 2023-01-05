<?php
declare(strict_types=1);


namespace App\Models;

use Exception;

class UserRepository extends Repository
{
    /**
     * Get user by email
     *
     * @param $email string The email to search for
     * @return User|null The user or null if not found
     * @throws Exception If the query fails
     */
    public function getUserByEmail(string $email): ?User
    {
        $data = $this->fetchOneBy('email', $email);
        if ($data === false) {
            return null;
        }
        return new User((array)$data);
    }

    /**
     * Get all users
     *
     * @return array The users
     */
    public function getUsers(): array
    {
        return $this->fetchAll();
    }
}
