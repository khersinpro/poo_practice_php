<?php

namespace App\Blog;

use Framework\Router;
use Psr\Http\Message\ServerRequestInterface;

class BlogController
{
    /**
     * Constructeur qui prend le router en param puis on créer les routes a injecter dans le router
     * @param Router Router de l'application
     */
    public function __construct(Router $router)
    {
        $router->get('/blog', [$this, 'index'], 'blog');
    }

    public function index(ServerRequestInterface $request)
    {
        return 'Bienvenu sur mon blog';
    }
}