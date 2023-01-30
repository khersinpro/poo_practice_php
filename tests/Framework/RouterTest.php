<?php

namespace Tests\Framework;

use Framework\Router;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @var Router
     */
    private $router;

    // La fonctions setUp se lance avant chaque lancement de test 
    public function setUp(): void
    {
        $this->router = new Router();
    }

    public function testGetMethod()
    {
        $request = new ServerRequest('GET', '/blog');
        // Création de la route => uri, callable, nom de route
        $this->router->get('/blog', function() {return 'hello';}, 'blog');
        $route = $this->router->match($request);
        $this->assertEquals('blog', $route->getName());
        $this->assertEquals('hello', call_user_func_array($route->getCallback(), [$request]));
    }
    
    public function testGetMethodIfUrlDoesNotExists()
    {
        $request = new ServerRequest('GET', '/blog');
        // Création de la route => uri, callable, nom de route
        $this->router->get('/mauvaiseuri', function() {return 'hello';}, 'blog');
        $route = $this->router->match($request);
        $this->assertEquals(null, $route->getName());
    }

    public function testGetMethodWithParam()
    {
        $request = new ServerRequest('GET', '/blog/mon-slug-8');
        // Route qui ne doit pas matcher
        $this->router->get('/blog', function() {return 'hello';}, 'posts');

        // Création de la route qui doit matcher => uri + slug lettres et chiffres + id chiffres, callable, nom de route
        $this->router->get('/blog/{slug: [a-z0-9\-]+}-{id: \d+}', function() {return 'hello';}, 'post.show');
        $route = $this->router->match($request);
        $this->assertEquals('post.show', $route->getName());
        $this->assertEquals('hello', call_user_func_array($route->getCallback(), [$request]));
        $this->assertEquals(['slug' => 'mon-slug', 'id' => '8' ], call_user_func_array($route->getParams(), [$request]));

        // Test url invalide
        $route = $this->router->match(new ServerRequest('GET', '/blog/mong_slug-8'));
        $this->assertEquals(null, $route);
    }

    public function testGenerateUri()
    {
        $this->router->get('/blog', function() {return 'hello';}, 'posts');
        $this->router->get('/blog/{slug: [a-z0-9\-]+}-{id:\d+}', function() {return 'hello';}, 'post.show');
        $uri = $this->router->generateUri('post.show', ['slug' => 'mon-article', 'id' => 18]);
        $this->assertEquals('/blog/mon-article-18', $uri);
    }
}