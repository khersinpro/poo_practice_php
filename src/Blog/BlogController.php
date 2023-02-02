<?php

namespace App\Blog;

use Framework\Module;
use Framework\Router;
use Psr\Http\Message\ServerRequestInterface;

class BlogController extends Module
{

    const DEFINITIONS = __DIR__.'/config.php';

    /**
     * Constructeur qui prend le router en param puis on créer les routes a injecter dans le router
     * @param Router Router de l'application
     */
    public function __construct(Router $router)
    {
        $router->get('/blog', [$this, 'index'], 'blog', ['GET']);
        $router->get('/blog/[slug:slug]/[digit:id]/[text:text]', [$this, 'show'], 'blog.show', ['POST', 'GET']);
    }

    public function index(ServerRequestInterface $request)
    {
        return '<h1>Bienvenue sur le blog</h1>';
    }

    public function show(ServerRequestInterface $request)
    {
        list($slug, $id, $test)= array_values($request->getQueryParams());
        return '<h1>Bienvenue sur l\'article '.$slug;
    }
}
