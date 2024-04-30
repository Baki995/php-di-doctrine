<?php

declare(strict_types=1);

namespace Bojan\PhpGrapejs\Posts;

use Bojan\PhpGrapejs\Common\BaseRepository;
use Doctrine\ORM\EntityManager;

class PostRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(PostModel::class);
    }

    public function get()
    {
        return $this->repository->findAll();
    }
}