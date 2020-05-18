<?php

use Symfony\Component\HttpFoundation\Request;

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/vendor/autoload.php';

$kernel = new App\Http\Kernel();

$response = $kernel->handle(
    Request::createFromGlobals()
);

$response->send();
