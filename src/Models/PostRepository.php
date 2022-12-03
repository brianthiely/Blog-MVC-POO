<?php
declare(strict_types=1);

namespace App\Models;

class PostRepository extends Repository
{
    public function getPosts(): array
    {
        return $this->fetchAll();
    }


}