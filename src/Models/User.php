<?php
declare(strict_types=1);

namespace App\Models;

use DateTime;
use Exception;

class User extends BaseEntity
{
    protected int $id;
    protected string $firstname;
    protected string $lastname;
    protected string $username;
    protected string $email;
    protected string $password;
    protected string $roles;
    protected string $csrfToken;
    protected DateTime $createdAt;
    protected ?DateTime $updatedAt;


    /**
     * Constructor hydrates the object
     *
     * @param array $data The data to hydrate the object with
     * @throws Exception
     */
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    /**
     * Verify if the role is admin
     *
     * @return bool True if the role is admin, false otherwise
     */
    public function isAdmin(): bool
    {
        return $this->getRoles() === 'admin';
    }

    /**
     * Set the user's role to admin
     *
     * @return void
     */
    public function setAdmin(): void
    {
        $this->setRoles('admin');
    }

    /**
     * Verify if the role is user
     *
     * @return bool True if the role is user, false otherwise
     */
    public function isUser(): bool
    {
        return $this->getRoles() === 'user';
    }

    /**
     * Return the user's id
     *
     * @return int The user's id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the user's id
     *
     * @param int $id The user's id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Return the user's firstname
     *
     * @return string The user's firstname
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * Set the user's firstname
     *
     * @param string $firstname The user's firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * Return the user's lastname
     *
     * @return string The user's lastname
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * Set the user's lastname
     *
     * @param string $lastname The user's lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * Return the user's username
     *
     * @return string The user's username
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Set the user's username
     *
     * @param string $username The user's username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * Return the user's email
     *
     * @return string The user's email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Set the user's email
     *
     * @param string $email The user's email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Check if the password is correct
     *
     * @param string $password The password to check
     * @return bool True if the password is correct, false otherwise
     */
    public function checkPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    /**
     * Set the user's password
     *
     * @param string $password The user's password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * Set the user's password with a hashed password
     *
     * @param string $password The user's password
     * @return void The user's password
     */
    public function setPasswordWithoutHash(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
    }

    /**
     * Return the user's roles
     *
     * @return string The user's roles
     */
    public function getRoles(): string
    {
        return $this->roles;
    }

    /**
     * Set the user's roles
     *
     * @param string $roles The user's roles
     */
    public function setRoles(string $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * Return the user's csrf token
     *
     * @return string The user's csrf token
     */
    public function getCsrfToken(): string
    {
        return $this->csrfToken;
    }

    /**
     * Generate a random token
     *
     * @return string The token generated
     * @throws Exception
     */
    public function generateCsrfToken(): string
    {
        $this->csrfToken = bin2hex(random_bytes(32));
        return $this->csrfToken;
    }

    /**
     * Verify if the token is valid and compare it to the token stored in the object.
     *
     * @param string $token The token to verify
     * @return bool `true` if the token is valid, `false` otherwise
     */
    public function checkCsrfToken(string $token): bool
    {
        return $token === $this->csrfToken;
    }

    /**
     * Return the user's creation date
     *
     * @return DateTime The user's creation date
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set the user's creation date
     *
     * @param DateTime $createdAt The user's creation date
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Return the user's update date
     *
     * @return DateTime The user's update date
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Set the user's update date
     *
     * @param DateTime|null $updatedAt The user's update date
     */
    public function setUpdatedAt(?DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
