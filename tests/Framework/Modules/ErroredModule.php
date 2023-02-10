<?php

namespace Tests\Framework\Modules;

use Framework\Router\Router;
use stdClass;

class ErroredModule
{
    public function __construct(Router $router)
    {
        $router->get('/test', function() {
            return new stdClass();
        }, 'error.route', ['GET']);
    }
}