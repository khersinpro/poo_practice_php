<?php

use Framework\Renderer\TwigRenderer;
use Framework\Router;
use function DI\autowire;
use function DI\get;

return  [
    'default.template.path' => __DIR__.'/../views',
    Router::class => autowire(),
    TwigRenderer::class => autowire()->constructor(get('default.template.path'))
];