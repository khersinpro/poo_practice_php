<?php

namespace Framework;

use Framework\Router\Route;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class Router
 * Permet de matcher les objets de type Route
 */
class Router 
{
    /**
     * @var Route[] Tbaleau des routes de l'application
     */
    private $routes;

    /**
     * @param string $path Uri de la route
     * @param callable $callable Fonction retourner par la route
     * @param string Nom de la route
     */
    public function get(string $path, callable $callable, string $name, array $methods): void
    {
        $this->routes[] = new Route($path, $callable, $name, $methods);
    }

    /**
     * Controle si la route demandé existe grace a la requete et l'uri qu'elle contient
     * @param ServerRequestInterface $request La requete entrante (format psr7)
     * @return Route|null Retourne une route si elle a matcher sinon null
     */
    public function match(ServerRequestInterface $request): ?Route
    {
        $uri = $request->getUri()->getPath();
        $method = $request->getMethod();
        $match;

        foreach ($this->routes as $route) {
            $route->getPath() === $uri && array_search($method, $route->getMethods(), true ) ? $match = $route : $match = null;
        }

        return $match;
    }

    /**
     * @param string $name Nom de la route
     * @param array $params Tableau de params
     * @return string|null retourne l'url générer ou null 
     */
    public function generateUri(string $name, array $params): ?string
    {
        return null;
    }
}