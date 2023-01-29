<?php

namespace Tests\Framework;

use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

// ./vendor/bin/phpunit tests/Framework/AppTest.php
class AppTest extends TestCase
{
    public function testRedirectTrailingSlash()
    {
        $app = new App();
        $request = new ServerRequest('GET', '/urltest/');
        $response = $app->run($request);
        // assertcontains pour controller le retour d'un array
        $this->assertContains('/urltest', $response->getHeader('Location'));
        // assertequals pour tester des egalités
        $this->assertEquals(301, $response->getStatusCode());
    }

    public function testBlog()
    {
        $app = new App();
        $request = new ServerRequest('GET', '/blog');
        $response = $app->run($request);
        // Pour le controle des strings
        $this->assertStringContainsString('<h1>Bienvenue sur le blog</h1>', $response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testError404()
    {
        $app = new App();
        $request = new ServerRequest('GET', '/aucuneroute');
        $response = $app->run($request);

        $this->assertStringContainsString('<h1>Erreur 404</h1>', $response->getBody());
        $this->assertEquals(404, $response->getStatusCode());
    }
}