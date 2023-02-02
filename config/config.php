<?php

use Framework\Router;
use Framework\Router\Route;
use function DI\autowire;

return  [
    // 'router' => function(){
    //     return new Router; },
    'key1' => 'abcds',
    Router::class => autowire()
];