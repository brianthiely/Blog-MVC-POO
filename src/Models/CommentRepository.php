<?php
declare(strict_types=1);

namespace App\Models;

class CommentRepository extends Repository
{
    public function getComments($id): bool|array
    {
        return $this->fetchBy(['post_id' => $id, 'visibility' => 1]);
    }
}