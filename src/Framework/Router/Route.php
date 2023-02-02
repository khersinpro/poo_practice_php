<?php

namespace Framework\Router;

/**
 * Class Route
 * Représente une route qui existante
 */
class Route
{
    /**
     * @var string Nom de la route
     */
    private string $name;

    /**
     * @var callable Callable de la route
     */
    private $callback;

    /**
     * @var array Tableau de params de la route
     */
    private array $parameters = [];
    
    /**
     * @var array Tableau de params de la route
     */
    private array $methods;
    
    /**
     * @var string Tableau de params de la route
     */
    private string $path;
    
    public function __construct(string $path, callable $callback, string $name, array $methods)
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->methods = $methods;
        $this->path = $path;
        // $this->parameters = $parameters;
    }

    /**
     * Récupére le chemin de la route
     * @return string Retourne un une chaine de caractère correspondant au chemin de la route
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Récupére le callback de la route
     * @return callable Retourne le callback de la route
     */
    public function getCallback(): callable
    {
        return $this->callback;
    }
    
    /**
     * Récupére le nom de la route
     * @return string Nom de la route
     */
    public function getName(): string
    {
        return $this->name;
    }
     
    /**
     * Récupére les types de requetes http autorisée de la route
     * @return string[] Retourne un tableau de type de requetes http
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * Retourne les params de la route
     * @return string[] Retourne un tableau de string / vide si aucun params
     */
    public function getParams(): array
    {
        return $this->parameters;
    }

    /**
     * Set les params de la route
     * @param string[] $parameters Retourne un tableau de string / vide si aucun params
     */
    public function setParams(array $parameters = []): void
    {
        $this->parameters = $parameters;
    }
}
