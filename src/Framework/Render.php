<?php

namespace Framework;

class Renderer
{
    const DEFAULT_NAMESPACE = '__MAIN';
    private $path= [];

    public function addPath(string $namespace, ?string $path = null): void
    {
        if (is_null($path)) {
            $this->path[self::DEFAULT_NAMESPACE] = $namespace;

        } else {
            $this->path[$namespace] = $path;
        }
    }

    public function render(string $path): string
    {
        return 'dffgd';
    }
}