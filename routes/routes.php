<?php

// Routes access from anyone
use App\Controllers\IndexController;
use App\Middleware\RedirectIfAuthenticated;
use App\Middleware\RedirectIfUnauthenticated;
use App\Middleware\StartSession;

$app->add(new StartSession($container['db']));

// Routes accessed only if not logged
$app->group('', function () {
    $this->get('/', IndexController::class . ':indexPage')->setName('index');
    $this->post('/login', IndexController::class . ':login')->setName('login');
})->add(new RedirectIfAuthenticated($container['router']));

// Routes accessed only if logged
$app->group('', function () {
    $this->get('/queue', IndexController::class . ':queuePage')->setName('queue');
})->add(new RedirectIfUnauthenticated($container['router']));