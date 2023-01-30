<?php

use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;

use function Http\Response\send;

require '../vendor/autoload.php';

$app = new App([
    Blogmodule::class
]);

// Passage de la request via le package guzzlehttp => app return la response
$response = $app->run(ServerRequest::fromGlobals());

send($response);
