<?php
declare(strict_types=1);

namespace App\Models;

use Exception;

class PostRepository extends Repository
{
    /**
     * @return array
     */
    public function getPosts(): array
    {
        return $this->fetchAll();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getPost(int $id): mixed
    {
        return $this->fetch($id);
    }

    public function deletePost(int $postId)
    {
        $this->delete($postId);
    }


}
