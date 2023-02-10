<?php

use App\Controller\BlogController;

use Framework\App;
use Framework\DependencyInjection\ContainerFactory;
use GuzzleHttp\Psr7\ServerRequest;
use function Http\Response\send;

require '../vendor/autoload.php';

$modules = [
    BlogController::class
];

$container = call_user_func(new ContainerFactory());
$app = new App($container, $modules);

// Passage de la request via le package guzzlehttp => app return la response
$response = $app->run(ServerRequest::fromGlobals());

send($response);
