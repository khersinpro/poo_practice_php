<?php

namespace Framework\Controller;

use Exception;
use Framework\Router;
use Psr\Container\ContainerInterface;

abstract class AbstractController
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Configuration pour la dependency injection du module
     */
    // const DEFINITIONS = __DIR__.'/config.php'?? null;

    /**
     * @param ContainerInterface 
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
    
    /**
     * Ajouter une route pour le controller depuis le controller
     * @param string $path Uri de la route
     * @param callable $callable Fonction retourner par la route
     * @param string $name Nom de la route
     * @param array $methods Tableau des types de requetes autorisées
     */
    protected function addRoute(string $path, callable $callable, string $name, array $methods): void
    {
        // if (!$this->container->has(Router::class)) {
        //     throw new Exception('La fonction addRoute ne contient pas l\'éxtension nécessaire à son fonctionnement.');
        // }
        $this->container->get(Router::class)->get($path, $callable, $name, $methods);
    }

    /**
     * Rendre une vue twig depuis un controller 
     * @param string $view Vue a retourner
     * @param array $params Tableau de params a passer a la vue
     */
    protected function render(string $view, array $params = []): mixed
    {
        if (!$this->container->has('twig')) {
            throw new Exception('La fonction render ne contient pas l\'éxtension nécessaire à son fonctionnement.');
        }
        return $this->container->get('twig')->render($view, $params);
    }

    /**
     * Ajouter des chemins spécifiques pour les templates (a supprimer quand l'implementation des configs de modules sera faite)
     */
    protected function addTwigTemplatePath($templateDirectory, $namespace)
    {
        if (!$this->container->has('twig')) {
            throw new Exception('La fonction addTwigTemplate ne contient pas l\'éxtension nécessaire à son fonctionnement.');
        }
        $this->container->get('twig')->addPath($templateDirectory, $namespace);
    }



}
