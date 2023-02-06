<?php

namespace App\Blog;

use Framework\Controller\AbstractController;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogController extends AbstractController
{
    const DEFINITIONS = __DIR__.'/config.php';

    /**
     * Constructeur qui prend le ContainerInterface afin de configuré l'abstractController qui detiens les outils de bases pour un controller
     * @param ContainerInterface Container afin d'injecter les methods utile a un controller
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->addTwigTemplatePath(__DIR__.'/templates', 'blog');
        $this->addRoute('/blog', [$this, 'index'], 'blog', ['GET']);
        $this->addRoute('/blog/[slug:slug]/[digit:id]/[text:text]', [$this, 'show'], 'blog.show', ['POST', 'GET']);
    }
    
    public function index(ServerRequestInterface $request)
    {
        // dd('ici');
        return $this->render('@blog/index.html.twig', [
            "name" => "Nom d'utilisateur",
        ]);
    }

    public function show(ServerRequestInterface $request)
    {
        list($slug, $id, $test)= array_values($request->getQueryParams());
        return '<h1>Bienvenue sur l\'article '.$slug;
    }
}
