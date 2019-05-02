<?php

// Routes access from anyone
use App\Controllers\IndexController;

$app->get('/', IndexController::class . ':index')->setName('index');
$app->get('/login', IndexController::class . ':login')->setName('login');
$app->get('/queue', IndexController::class . ':queue')->setName('queue');
