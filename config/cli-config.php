<?php

require_once __DIR__.'/../vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\ORM\EntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\ORM\ORMSetup;

$config = new PhpFile(__DIR__.'/migrations.php'); // Or use one of the Doctrine\Migrations\Configuration\Configuration\* loaders

// Create a simple "default" Doctrine ORM configuration for Attributes
$ORMconfig = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__.'/../src/Entity'],
    isDevMode: true,
);

// configuring the database connection
$db_connexion = require_once __DIR__.'/db_configuration.php';
$connection = DriverManager::getConnection($db_connexion, $ORMconfig);

// obtaining the entity manager
$entityManager = new EntityManager($connection, $ORMconfig);

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));