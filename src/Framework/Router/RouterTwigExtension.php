<?php

namespace Framework\Router;

use Framework\Router\Router;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RouterTwigExtension extends AbstractExtension
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Ajout des fonction directement dans les vues
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('path', [$this, 'generatePath'])
        ];
    }

    /**
     * Génere la path d'une route
     * @param string $routename Nom de la route
     * @param array $params Params de la route
     * @return string|null
     */
    public function generatePath(string $routeName, array $params = []): ?string
    {
        if ($this->router instanceof Router) {
            $uri = $this->router->generateUri($routeName, $params);
            return $uri;
        }
    }
}
