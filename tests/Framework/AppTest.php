<?php

namespace Tests\Framework;

use App\Blog\BlogController;
use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Tests\Framework\Modules\ErroredModule;
use Tests\Framework\Modules\StringModule;

// ./vendor/bin/phpunit tests/Framework/AppTest.php
class AppTest extends TestCase
{
    public function testRedirectTrailingSlash()
    {
        $app = new App([
            BlogController::class
        ]);
        $request = new ServerRequest('GET', '/urltest/');
        $response = $app->run($request);
        // assertcontains pour controller le retour d'un array
        $this->assertContains('/urltest', $response->getHeader('Location'));
        // assertequals pour tester des egalités
        $this->assertEquals(301, $response->getStatusCode());
    }

    public function testBlog()
    {
        $app = new App([
            BlogController::class
        ]);
        $request = new ServerRequest('GET', '/blog');
        $response = $app->run($request);

        // Pour le controle des strings
        $this->assertStringContainsString('<h1>Bienvenue sur le blog</h1>', $response->getBody());
        $this->assertEquals(200, $response->getStatusCode());

        // Pour les requetes avec params
        $requestParam = new ServerRequest('GET', '/blog/mon-slug/12/text');
        $responseParam = $app->run($requestParam);
        $this->assertEquals('<h1>Bienvenue sur l\'article mon-slug', $responseParam->getBody());
    }

    public function testError404()
    {
        $app = new App([
            BlogController::class
        ]);
        $request = new ServerRequest('GET', '/aucuneroute');
        $response = $app->run($request);

        $this->assertStringContainsString('<h1>Erreur 404</h1>', $response->getBody());
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testThrowException()
    {
        $app = new App([
            ErroredModule::class
        ]);

        $request = new ServerRequest('GET', '/test');
        $this->expectException(\Exception::class);
        $app->run($request);
    }

    public function testConvertStringToResponse()
    {
        $app = new App([
            StringModule::class
        ]);

        $request = new ServerRequest('GET', '/test');
        $response =  $app->run($request);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals('TEST', $response->getBody());
    }
}