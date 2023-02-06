<?php

namespace Framework\Renderer;

interface RendererInterface
{
    /**
     * @param string $templateDirectory Dossier de templates a ajouter
     * @param string $namespace Namespace a assigner au dossier de template
     */
    public function addPath(string $templateDirectory, string $namespace): void;

    /**
     * @param string $view Vue a rendre
     * @param array $params Params destiné a la vue
     */
    public function render(string $view, array $params = []);


    /**
     * @param string $key Clé de la valeur globale a ajouter
     * @param mixed $value Valeur de la globale a ajouter
     */
    public function addGLobal(string $key, mixed $value);
}
