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

        'database' => [
            'driver' => $_ENV['DB_DRIVER'],
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'name' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASS'],
            'charset' => $_ENV['DB_CHARSET'],
            'collation' => $_ENV['DB_COLLATION']
        ],
    ]
]);

// Get container
$container = $app->getContainer();

// Connect to database
$db = new \App\Utils\Database();
$container['db'] = $db->connect($container['settings']['database']);

// Start session
$sessionHandler = new App\Utils\Session($container->get('db'));
session_set_save_handler($sessionHandler);
session_name($_ENV['SESSION_NAME']);
session_start();

// Set dependencies in container
require __DIR__ . '/dependencies.php';

require dirname(__DIR__) . '/routes/routes.php';
