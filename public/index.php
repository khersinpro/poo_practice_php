<?php

use App\Blog\BlogController;
use DI\ContainerBuilder;
use Framework\App;
use Framework\Controller\AbstractController;
use Framework\Controller\ToolsController;
use GuzzleHttp\Psr7\ServerRequest;

use function Http\Response\send;

require '../vendor/autoload.php';

$modules = [
    BlogController::class
];

// Création du container d'injection et passage des configs de base
// Puis si des configs specifique on été ajouté a un module, on les injecte via le foreach
$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__.'/../config/config.php');
foreach ($modules as $module) {
    if ($module::DEFINITIONS !== null) {
        $builder->addDefinitions($module::DEFINITIONS);
    }
}
$container = $builder->build();

$app = new App($container, $modules);

// Passage de la request via le package guzzlehttp => app return la response
$response = $app->run(ServerRequest::fromGlobals());

send($response);
