<?php

declare(strict_types=1);

namespace App\Service\Factory;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

class Database
{
    private const ENTITY_PATH = __DIR__ . '/../Entity';

    /** @var string $databaseUrl */
    private $databaseUrl;

    /** @var string $driver */
    private $driver;

    /** @var EntityManagerInterface $em */
    private $em;

    public function __construct(string $databaseUrl, string $driver)
    {
        $this->databaseUrl = $databaseUrl;
        $this->driver = $driver;
    }

    public function getEntityManager(): EntityManagerInterface
    {
        if (null === $this->em) {
            $paths = [
                static::ENTITY_PATH,
            ];

            $connectionParams = [
                'url' => $this->databaseUrl,
                'driver' => $this->driver,
            ];

            $conn = DriverManager::getConnection($connectionParams);

            $config = Setup::createAnnotationMetadataConfiguration($paths, false, null, null, false);

            $this->em = EntityManager::create($conn, $config);
        }

        return $this->em;
    }

    /**
     * @param string $className
     *
     * @return mixed
     */
    public function getRepository(string $className)
    {
        return $this->getEntityManager()->getRepository($className);
    }
}
