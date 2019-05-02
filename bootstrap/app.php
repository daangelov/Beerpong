<?php

require dirname(__DIR__) . '/vendor/autoload.php';

// Load environment variables form .env
$dotenv = Dotenv\Dotenv::create(dirname(__DIR__));
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
