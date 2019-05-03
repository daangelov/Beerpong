<?php

require dirname(__DIR__) . '/vendor/autoload.php';

// Load environment variables form .env
$factory = new \Dotenv\Environment\DotenvFactory([
    new \Dotenv\Environment\Adapter\EnvConstAdapter(),
    new \Dotenv\Environment\Adapter\ServerConstAdapter()
]);

$dotenv = \Dotenv\Dotenv::create(dirname(__DIR__), null, $factory);
$dotenv->load();

// Create app
$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => getenv('APP_DEBUG') === "true",
        'determineRouteBeforeAppMiddleware' => true,
    ]
]);

// Set dependencies in container
require __DIR__ . '/container.php';

require dirname(__DIR__) . '/routes/routes.php';
