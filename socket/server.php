<?php

define('BASE_PATH',dirname(__DIR__));

require BASE_PATH. '/vendor/autoload.php';

$config = config('socket');

$kernel = new App\Ws\Kernel();

$app = $kernel->handle(
    new Ratchet\App($config['host'],$config['port'])
);

$app->run();