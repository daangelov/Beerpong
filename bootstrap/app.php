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
        'displayErrorDetails' => $_ENV['APP_DEBUG'] === "true",
        'determineRouteBeforeAppMiddleware' => true,
    ]
]);

// Load constants
require __DIR__ . '/constants.php';

// Set dependencies in container
require __DIR__ . '/container.php';

// Set routes
require dirname(__DIR__) . '/routes/routes.php';
