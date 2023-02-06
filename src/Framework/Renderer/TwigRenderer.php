<?php

namespace Framework\Renderer;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigRenderer implements RendererInterface
{
    /**
     * @var Twig\Environment
     */
    protected $twig;

    /**
     * @var Twig\Loader\FilesystemLoader
     */
    private $loader;

    /**
     * @param string $path Chemin vers le dossier des templates twig 
     */
    public function __construct(string $path)
    {   
        $this->loader = new FilesystemLoader($path);
        $this->twig = new Environment($this->loader, []);
    }

    public function addPath(string $templateDirectory, string $namespace): void
    {
        $this->loader->addPath($templateDirectory, $namespace);
    }

    public function render(string $view, array $params = [])
    {
        return $this->twig->render($view, $params);
    }

    public function addGLobal(string $key, mixed $value)
    {
        $this->twig->addGLobal($key, $value);
    }

    function addExtension(mixed $extension)
    {
        $this->twig->addExtension($extension);
    }
}