<?php
declare(strict_types=1);

namespace App\Models;

use DateTime;
use Exception;

class Comment extends BaseEntity
{
    protected int $id;
    protected int $post_id;
    protected int $user_id;
    protected string $author;
    protected string $content;
    protected int $visibility;
    protected DateTime $createdAt;
    protected ?DateTime $updatedAt;

    /**
     * Hydrate the object with data
     *
     * @param array $data
     * @throws Exception
     * @return void
     */
    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    /**
     * Get the value of id
     *
     * @return int The value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param int $id The value of id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Get the value of post_id
     *
     * @return int The value of post_id
     */
    public function getPost_id(): int
    {
        return $this->post_id;
    }

    /**
     * Set the value of post_id
     *
     * @param int $post_id The value of post_id
     * @return void
     */
    public function setPost_id(int $post_id): void
    {
        $this->post_id = $post_id;
    }

    /**
     * Get the value of user_id
     *
     * @return int The value of user_id
     */
    public function getUser_id(): int
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @param int $user_id The value of user_id
     * @return void
     */
    public function setUser_id(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * Get the value of author
     *
     * @return string The value of author
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * Set the value of author
     *
     * @param string $author The value of author
     * @return void
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * Get the value of content
     *
     * @return string The value of content
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Set the value of content
     *
     * @param string $content The value of content
     * @return void
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * Get the value of visibility
     *
     * @return int The value of visibility
     */
    public function getVisibility(): int
    {
        return $this->visibility;
    }

    /**
     * Set the value of visibility
     *
     * @param int $visibility The value of visibility
     * @return void
     */
    public function setVisibility(int $visibility): void
    {
        $this->visibility = $visibility;
    }

    /**
     * Get the value of createdAt
     *
     * @return DateTime The value of createdAt
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @param DateTime $createdAt The value of createdAt
     * @return void
     */
    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Get the value of updatedAt
     *
     * @return DateTime The value of updatedAt
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @param DateTime|null $updatedAt The value of updatedAt
     * @return void
     */
    public function setUpdatedAt(?DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
