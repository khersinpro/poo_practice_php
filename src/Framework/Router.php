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
     * @param string $name Nom de la route
     * @param array $methods Tableau des types de requetes autorisées
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
        $requestMethod = $request->getMethod();
        $matchedRoute = null;

        foreach ($this->routes as $route) {
            $routePath = $route->getPath();

            // Controlle de la methode
            if (!in_array($requestMethod, $route->getMethods())) {
                return null;
            }

            // Controle si route sans params et si les url concorde
            if (!str_contains($routePath, '[') && $routePath === $uri) {
                return $matchedRoute = $route;
            }
            
            // Route complexe avec params => Controle si l'url match avec la regex de la route
            if (str_contains($routePath, '[')) {
                $regex = $this->routeRegexGenerator($routePath);

                if (preg_match($regex, $request->getUri()->getPath(), $matches) === 1) {
                    // Récupération des params de la route
                    $routeParams = array_reduce(array_keys($matches), function ($routeParams, $key) use ($matches) {
                        if (is_string($key)) {
                            $routeParams[$key] = $matches[$key];
                        }
                        return $routeParams;
                    }, []);

                    $route->setParams($routeParams);

                    $matchedRoute = $route;
                }
            }
        }

        return $matchedRoute;
    }

    /**
     * Génére l'url d'une route avec ses params
     * @param string $name Nom de la route
     * @param array $params Tableau de params
     * @return string|null retourne l'url générer ou null
     */
    public function generateUri(string $name, array $params): ?string
    {
        foreach ($this->routes as $route) {
            if ($route->getName() === $name) {
                $url = $route->getPath();
                
                if (!str_contains($url, '[')) {
                    return $url;
                } elseif (preg_match_all('`(/|\.|)\[([^:\]]*+)(?::([^:\]]*+))?\](\?|)`', $url, $matches, PREG_SET_ORDER)) {
                    foreach ($matches as $matche) {
                        list($block, $pre, $pattern, $key) = $matche;
                        $param = $pre . $params[$key] ;
                        $url = str_replace($block, $param, $url);
                    }
                } else {
                    $url = null;
                }
            }
        }

        return $url ? $url : null;
    }

    /**
     * Génére la regex pour controler les parametres donnés dans une requetes
     * @param $route
     * @return string
     */
    protected function routeRegexGenerator(string $route): string
    {
        if (preg_match_all('`(/|\.|)\[([^:\]]*+)(?::([^:\]]*+))?\](\?|)`', $route, $matches, PREG_SET_ORDER)) {
            $matchTypes = $this->matchTypes;
    
            foreach ($matches as $match) {
                list($block, $pre, $type, $param) = $match;
    
                if (isset($matchTypes[$type])) {
                    $type = $matchTypes[$type];
                }

                // création du pattern de regex et remplacement du block dans l'url de control de route
                $pattern = '(?:' . ($pre !== '' ? $pre : null) . '('. ($param !== '' ? "?P<$param>" : null) . $type . ')' . ')';
    
                $route = str_replace($block, $pattern, $route);
            }
        }

        return "#^$route$#";
    }
}
