<?php

use Fr05t1k\SlimExample\Application;

require __DIR__ . '/../vendor/autoload.php';


$dotEnv = new \Dotenv\Dotenv(__DIR__ . '/..');
$dotEnv->load();

$application = new Application();

/** @var array $routes */
$routes = require __DIR__ . '/../configs/http-routes.php';

foreach ($routes as $route) {
    [$method, $pattern, $handler] = $route;
    $application->$method($pattern, $handler);
}

$application->run();