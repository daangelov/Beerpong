<?php

// Register view in container
$container['view'] = function ($container) {

    $view = new Slim\Views\Twig(dirname(__DIR__) . '/resources/views/', [
        'cache' => false,
        'debug' => $_ENV['APP_DEBUG'] === "true"
    ]);

    // Instantiate and add Slim specific extension
    $router = $container->router;
    $uri = \Slim\Http\Uri::createFromEnvironment(new \Slim\Http\Environment($_SERVER));
    $view->addExtension(new Slim\Views\TwigExtension($router, $uri));

    return $view;
};

$container['notFoundHandler'] = function ($container) {
    return new \App\Handlers\NotFoundHandler($container->view);
};
