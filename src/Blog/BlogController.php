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
        $router->get('/blog', [$this, 'index'], 'blog', ['GET']);
        $router->get('/blog/[slug: [a-z\-]+]/[id: /d+]/[text: [a-z]+]', [$this, 'index'], 'blog', ['GET']);
    }

    public function index(ServerRequestInterface $request, int $id)
    {
        return 'Bienvenu sur mon blog'.$id.'id';
    }
}