<?php

require_once __DIR__.'/../vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

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

return $entityManager;