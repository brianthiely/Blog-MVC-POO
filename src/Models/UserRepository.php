<?php
declare(strict_types=1);


namespace App\Models;

use Exception;

class UserRepository extends Repository
{
    /**
     * @param $email
     * @return User|null
     * @throws Exception
     */
    public function getUserByEmail($email): ?User
    {
        $data = $this->fetchOneBy('email', $email);
        if ($data === false) {
            return null;
        }
        return new User((array)$data);
    }

    /**
     * @return array
     */
    public function getUsers(): array
    {
        return $this->fetchAll();
    }
}
