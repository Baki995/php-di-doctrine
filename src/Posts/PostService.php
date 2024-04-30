<?php

declare(strict_types=1);

namespace Bojan\PhpGrapejs\Posts;

class PostService
{
    public function __construct(
        private readonly PostRepository $postRepository
    ) {
    }

    public function get()
    {
        return array_map(function (PostModel $model) {
            return $model->toObject();
        }, $this->postRepository->get());
    }
}