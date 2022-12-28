<?php
declare(strict_types=1);

namespace App\Models;

class CommentRepository extends Repository
{
    /**
     * Get all comments for a post
     *
     * @param int $postId The post id
     * @return bool|array The comments or false if none found
     */
    public function getCommentsByPost(int $postId): bool|array
    {
        return $this->fetchBy(['post_id' => $postId, 'visibility' => 1]);
    }

    /**
     * Get all comments valid for a post
     *
     * @param int $commentId
     * @return void The comments or false if none found
     */
    public function validateComment(int $commentId): void
    {
        $this->updateOneBy('visibility', 1, (string)$commentId);
    }

    /**
     * Get all comments waiting for validation for a post
     *
     * @return array The comments or false if none found
     */
    public function getAdminComments(): array
    {
        return $this->fetchBy(['visibility' => 0]);
    }
}
