<?php
declare(strict_types=1);

namespace App\Models;

class CommentRepository extends Repository
{
    public function getCommentsByPost($postId): bool|array
    {
        return $this->fetchBy(['post_id' => $postId, 'visibility' => 1]);
    }

    public function validateComment($commentId)
    {
        $this->updateOneBy('visibility', 1, $commentId);
    }

    public function getAdminComments(): array
    {
        return $this->fetchBy(['visibility' => 0]);
    }

}
