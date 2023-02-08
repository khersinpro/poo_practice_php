<?php

namespace Framework\Renderer;

use Psr\Container\ContainerInterface;

/**
 * Permet d'invoke la class TwigRenderer avec toutes les extensions Twig implémenté
 */
class TwigRendererFactory
{
    /**
     * @param ContainerInterface $container
     * @param TwigRenderer $twig
     */
    public function __invoke(ContainerInterface $container, TwigRenderer $twig): TwigRenderer
    {
        foreach ($container->get('twig.extensions') as $extension) {
            $twig->addExtension($extension);
        }
        
        return $twig;
    }
}
