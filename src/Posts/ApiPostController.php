<?php

declare(strict_types=1);

namespace Bojan\PhpGrapejs\Posts;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ApiPostController
{
    public function __construct(
        private readonly PostService $postService
    ) {
    }

    public function index(ServerRequestInterface $request, array $args): ResponseInterface
    {
        return new JsonResponse([
            'posts' => $this->postService->get(),
        ]);
    }
}