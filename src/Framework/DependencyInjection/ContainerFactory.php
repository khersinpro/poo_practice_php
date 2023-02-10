<?php

namespace Framework\DependencyInjection;

use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

class ContainerFactory
{
    public function __invoke(): ContainerInterface
    {
        // Création du container d'injection et passage des configs de base
        // Puis si des configs specifique on été ajouté a un module, on les injecte via le foreach
        $builder = new ContainerBuilder();
        $builder->addDefinitions(__DIR__.'/di_config.php');

        $container = $builder->build();
        
        return $container;
    }
}
