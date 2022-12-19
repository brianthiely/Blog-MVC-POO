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
     * @throws Exception
     */
    public function __construct(array $data)
    {
        $this->hydrate($data);
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
     * @return int
     */
    public function getPost_id(): int
    {
        return $this->post_id;
    }

    /**
     * @param int $post_id
     */
    public function setPost_id(int $post_id): void
    {
        $this->post_id = $post_id;
    }

    /**
     * @return int
     */
    public function getUser_id(): int
    {
        return $this->user_id;
    }

    /**
     * @param int $user_id
     */
    public function setUser_id(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return int
     */
    public function getVisibility(): int
    {
        return $this->visibility;
    }

    /**
     * @param int $visibility
     */
    public function setVisibility(int $visibility): void
    {
        $this->visibility = $visibility;
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
