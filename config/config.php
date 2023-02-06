<?php

use Framework\Renderer\TwigRenderer;
use Framework\Renderer\TwigRendererFactory;
use Framework\Router\Router;
use Framework\Router\RouterTwigExtension;
use Psr\Container\ContainerInterface;

use function DI\autowire;
use function DI\factory;
use function DI\get;

return  [
    'default.template.path' => __DIR__.'/../views',
    'twig.extensions' => [
        get(RouterTwigExtension::class)
    ],
    Router::class => autowire(),
    TwigRenderer::class => autowire()->constructor(get('default.template.path')),
    'twig' => factory(TwigRendererFactory::class),
    ContainerInterface::class => autowire()
];