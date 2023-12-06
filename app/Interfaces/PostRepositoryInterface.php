<?php

namespace App\Interfaces;

interface PostRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function toggleLike($postId, $userId);
}
