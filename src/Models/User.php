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
     * @throws Exception
     */
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    public function isAdmin(): bool
    {
        return $this->getRoles() === 'admin';
    }

    public function setAdmin(): void
    {
        $this->setRoles('admin');
    }

    public function isUser(): bool
    {
        return $this->getRoles() === 'user';
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

    /**
     * @param string $password
     * @return bool
     */
    public function checkPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setPasswordWithoutHash(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
    }

    /**
     * @return string
     */
    public function getRoles(): string
    {
        return $this->roles;
    }

    /**
     * @param string $roles
     */
    public function setRoles(string $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @return string
     */
    public function getCsrfToken(): string
    {
        return $this->csrfToken;
    }

    /**
     * Génère un token CSRF aléatoire et le stocke dans la propriété de l'objet.
     *
     * @return string Le token CSRF généré
     * @throws Exception
     */
    public function generateCsrfToken(): string
    {
        $this->csrfToken = bin2hex(random_bytes(32));
        return $this->csrfToken;
    }

    /**
     * Vérifie si un token CSRF est valide en le comparant au token stocké dans la propriété de l'objet.
     *
     * @param string $token Le token CSRF à vérifier
     * @return bool `true` si le token est valide, `false` sinon
     */
    public function checkCsrfToken(string $token): bool
    {
        return $token === $this->csrfToken;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime|null $updatedAt
     */
    public function setUpdatedAt(?DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
