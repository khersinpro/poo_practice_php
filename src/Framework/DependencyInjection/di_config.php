<?php

use Doctrine\ORM\EntityManagerInterface;
use Framework\Renderer\TwigRenderer;
use Framework\Renderer\TwigRendererFactory;
use Framework\Router\Router;
use Framework\Router\RouterTwigExtension;
use Psr\Container\ContainerInterface;
use Tests\Framework\Modules\ErroredModule;
use Tests\Framework\Modules\StringModule;
use function DI\autowire;
use function DI\factory;
use function DI\get;

return  [
    'default.template.path' => __DIR__.'/../../templates',
    'twig.extensions' => [
        get(RouterTwigExtension::class)
    ],
    Router::class => autowire(),
    TwigRenderer::class => factory(TwigRendererFactory::class),
    ContainerInterface::class => autowire(),
    EntityManagerInterface::class => function(){ return require __DIR__.'/../../../config/entity_manager.php' ; },
    StringModule::class => autowire(),
    ErroredModule::class => autowire(),
];