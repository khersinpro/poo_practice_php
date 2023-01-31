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
     * @var array Tableau des types de params ajoutable sur une route
     */
    private $matchTypes = [
        'digit'  => '[0-9]++',
        'slug'  => '[a-z0-9\-]+',
        'text'  => '[a-z0-9]+',
    ];

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
        $match = null;

        foreach ($this->routes as $route) {
            /**
             * TODO => Créer la logique de controle des routes 
             * $matchedRoute = null;
             * foreach($this->routes as $route) {
             * $regex = $this->routeRegexGenerator();
             * 
             *  preg_match($regex, $route->getPath(), $matches) === 1 ? $matcherRoute = $route ? ''; 
             * }
             */
            $regex = $this->routeRegexGenerator();
            dd($regex, preg_match($regex, '/blog', $matches), $matches);

            if ($route->getPath() === $uri && in_array($method, $route->getMethods(), true )) {
                $match = $route; 
            }
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

    /**
     * Génére la regex pour controler les parametres donnés dans une requetes
     * @param $route
     * @return string
     */
    protected function routeRegexGenerator($route = '/blog')
    {

        /**
         * Finaliser la fonction pour qu'elle ne se lance que si le preg_match all retourne true
         */
        preg_match_all('`(/|\.|)\[([^:\]]*+)(?::([^:\]]*+))?\](\?|)`', $route, $matches, PREG_SET_ORDER);

        $matchTypes = $this->matchTypes;

        foreach ($matches as $match) {
            list($block, $pre, $type, $param, $optional) = $match;

            if (isset($matchTypes[$type])) {
                $type = $matchTypes[$type];
            }
            if ($pre === '.') {
                $pre = '\.';
            }

            $optional = $optional !== '' ? '?' : null;

            /**
             * Ajuster la concaténation du pattern pour garder uniquement le necessaire
            */
            $pattern = '(?:'
                    . ($pre !== '' ? $pre : null)
                    . '('
                    . ($param !== '' ? "?P<$param>" : null)
                    . $type
                    . ')'
                    . $optional
                    . ')'
                    . $optional;

            $route = str_replace($block, $pattern, $route);
        }
        
        return "#^$route$#";
    }
}