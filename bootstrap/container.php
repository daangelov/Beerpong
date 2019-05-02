<?php

// Get container
$container = $app->getContainer();

// Register database connection
$container['db'] = function () {
    $connectionString = $_ENV['DB_DRIVER'] .
        ':host=' . $_ENV['DB_HOST'] .
        ';port=' . $_ENV['DB_PORT'] .
        ';dbname=' . $_ENV['DB_NAME'] .
        ';charset=' . $_ENV['DB_CHARSET'] .
        ';collation=' . $_ENV['DB_COLLATION'];

    $db = new PDO($connectionString, $_ENV['DB_USER'], $_ENV['DB_PASS']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $db;
};

// Register view in container
$container['view'] = function ($container) {

    $view = new Slim\Views\Twig(dirname(__DIR__) . '/resources/views/', [
        'cache' => false,
        'debug' => $_ENV['APP_DEBUG'] === "true"
    ]);

    // Instantiate and add Slim specific extension
    $router = $container['router'];
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));
    $view->addExtension(new \Twig\Extension\DebugExtension());
    $view->getEnvironment()->addGlobal('flash', $container['flash']);
    return $view;
};

// Register flash messages
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

// Register not found handler
$container['notFoundHandler'] = function ($container) {
    return new \App\Handlers\NotFoundHandler($container->view);
};