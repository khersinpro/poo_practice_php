<?php

// retourne les config specifique a la dependency injection pour ce module

use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRenderer;
use function DI\autowire;

return [
    RendererInterface::class => autowire(),
    // TwigRenderer::class => function(){return new TwigRenderer();},
    "montest" => 'ça marche'
];