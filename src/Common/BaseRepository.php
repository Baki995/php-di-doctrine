<?php

declare(strict_types=1);

namespace Bojan\PhpGrapejs\Common;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMSetup;

class BaseRepository
{
    protected EntityRepository $repository;

    public function __construct(string $modelClass)
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            [__DIR__."/../../src"],
            true,
        );

        $dbConfig = require __DIR__.'/../../config/database.php';

        $connection = DriverManager::getConnection(
            $dbConfig['connections']['mysql'],
            $config
        );

        $entityManager = new EntityManager($connection, $config);
        $this->repository = $entityManager->getRepository($modelClass);
    }
}