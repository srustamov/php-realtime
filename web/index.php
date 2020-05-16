<?php

use Symfony\Component\HttpFoundation\Request;

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/vendor/autoload.php';

$request = Request::createFromGlobals();

$response = App\Providers\HttpRouteProvider::register(
    $request
);

$response->send();