<?php

namespace Framework;

use Exception;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
    /**
     * @var array Liste des module injecter dans l'application
     */
    private array $modules = [];

    /**
     * @var Router Router de l'application
     */
    private $router;

    /**
     * Constructeur qui prend en compte les modules a charger et qui leurs inject en param le router
     * @param string[] $modules Listes de modules a charger
     */
    public function __construct(array $modules = []) {
        $this->router = new Router();

        foreach ($modules as $module) {
            $this->modules[] = new $module($this->router);
        }
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        
        if (!empty($uri) && $uri[-1] === '/') {
            return new Response(301, [
                "Location" => substr($uri, 0, -1)
            ]);
        }

        $route = $this->router->match($request);

        if (!$route) {
            return new Response(404, [], '<h1>Erreur 404</h1>');
        }

        $request = $request->withQueryParams($route->getParams());
        $reponse = call_user_func($route->getCallback(), $request);
        
        if (is_string($reponse)) {
            return new Response(200, [], $reponse);
        } else if ($reponse instanceof ResponseInterface) {
            return new Response(200, [], $reponse);
        } else {
            throw new Exception('Find no response !');
        }
    }
}
