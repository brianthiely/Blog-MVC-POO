<?php
declare(strict_types=1);

namespace App\Models;

use Exception;

class User extends BaseEntity
{
    protected int $id;
    protected string $firstname;
    protected string $lastname;
    protected string $username;
    protected string $email;
    protected string $hashPassword;
    protected string $role;
    protected string $createdAt;
    protected string $updatedAt;


    /**
     * @throws Exception
     */
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    public function isAdmin(): bool
    {
        return $this->getRole() === 'admin';
    }

    public function setAdmin(): void
    {
        $this->setRole('admin');
    }

    public function isUser(): bool
    {
        return $this->getRole() === 'user';
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function checkPassword(string $password): bool
    {
        return password_verify($password, $this->hashPassword);
    }

    /**
     * @return string
     */
    public function getHashPassword(): string
    {
        return $this->hashPassword;
    }

    /**
     * @param string $hashPassword
     */
    public function setHashPassword(string $hashPassword): void
    {
        $this->hashPassword = $hashPassword;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * @param string $updatedAt
     */
    public function setUpdatedAt(string $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
