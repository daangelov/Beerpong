<?php

use App\Controllers\AuthController;
use App\Controllers\GameController;
use App\Controllers\IndexController;
use App\Controllers\QueueController;
use App\Middleware\RedirectIfAuthenticated;
use App\Middleware\RedirectIfUnauthenticated;
use App\Middleware\StartSession;

$app->add(new StartSession($container['db']));

// Routes access from anyone

// Routes accessed only if not logged
$app->group('', function () {
    $this->get('/', IndexController::class . ':indexPage')->setName('index');
    $this->post('/login', AuthController::class . ':login')->setName('login');
})->add(new RedirectIfAuthenticated($container['router']));

// Routes accessed only if logged
$app->group('', function () {
    $this->get('/queue', QueueController::class . ':queuePage')->setName('queue');
    $this->post('/logout', AuthController::class . ':logout')->setName('logout');
    $this->get('/check-start', QueueController::class . ':checkStart')->setName('checkStart');
    $this->get('/check-queue', QueueController::class . ':checkQueue')->setName('checkQueue');
    $this->get('/game', GameController::class . ':gamePage')->setName('game');
})->add(new RedirectIfUnauthenticated($container['router']));
