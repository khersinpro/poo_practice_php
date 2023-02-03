<?php

namespace Framework\Renderer;

interface RendererInterface
{
    public function addPath($templateDirectory, $namespace);

    public function render(string $view, array $params = []);

    public function addGLobal(string $key, mixed $value);
}
