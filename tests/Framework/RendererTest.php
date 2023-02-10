<?php

namespace Tests\Framework;

use Framework\DependencyInjection\ContainerFactory;
use Framework\Renderer\TwigRenderer;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class RendererTest extends TestCase
{
    private $renderer;
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setUp(): void
    {
        $this->container = call_user_func(new ContainerFactory());
        $this->renderer = $this->container->get(TwigRenderer::class);
    }

    public function testRenderRightPath()
    {
        $this->renderer->addPath(__DIR__.'/views', 'blog');
        $content = $this->renderer->render('@blog/demo.html.twig');
        $this->assertEquals('Page de demo', $content);
    }
}