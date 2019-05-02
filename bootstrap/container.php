<?php

// Get container
$container = $app->getContainer();

// Register database connection
$container['db'] = function ($container) {
    $db = new \App\Utils\Database();
    return $db->connect($container['settings']['database']);
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