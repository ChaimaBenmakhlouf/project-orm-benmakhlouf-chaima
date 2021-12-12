<?php

use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;



require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/db.php';


$app = AppFactory::create();
$app->addBodyParsingMiddleware();

// Define app routes
$app->get('/hello/{name}', function (Request $request, Response $response, $args) {
	$name = $args['name'];
	$response->getBody()->write("Hello, $name");
	return $response;
});

require __DIR__ . '/../app/routes.php';

// Run app
$app->run();
