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

    public function getFunctions()
    {
        return [
            new TwigFunction('path', [$this, 'generatePath'])
        ];
    }

    public function generatePath(string $routeName, array $params = []): ?string
    {
        if ($this->router instanceof Router) {
            $uri = $this->router->generateUri($routeName, $params);
            return $uri;
        }
    }
}
