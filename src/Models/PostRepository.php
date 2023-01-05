<?php
declare(strict_types=1);

namespace App\Models;

use Exception;

class PostRepository extends Repository
{
    /**
     * Get all posts
     *
     * @return array
     */
    public function getPosts(): array
    {
        return $this->fetchAll();
    }

    /**
     * Get post by id
     *
     * @param int $id
     * @return mixed
     */
    public function getPost(int $id): mixed
    {
        return $this->fetch($id);
    }

    /**
     * Delete post by id
     *
     * @param int $postId
     * @return void
     */
    public function deletePost(int $postId): void
    {
        $this->delete($postId);
    }
}
