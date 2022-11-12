<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Http\Controllers\IndexController;
use Slim\Http\Response;
use Slim\Factory\AppFactory;

$app = AppFactory::create();
$app->addRoutingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$app->get('/', IndexController::class . ':home');
$app->run();
