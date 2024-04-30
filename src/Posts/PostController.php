<?php

declare(strict_types=1);

namespace Bojan\PhpGrapejs\Posts;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class PostController
{
    public function __construct(
        private readonly PostService $postService
    ) {
    }

    public function index(ServerRequestInterface $request): ResponseInterface
    {
        return view('posts', ['posts' => $this->postService->get()]);
    }
}