<?php
declare(strict_types=1);

namespace App\Models;

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
}