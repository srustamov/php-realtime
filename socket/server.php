<?php

define('BASE_PATH',dirname(__DIR__));

require BASE_PATH. '/vendor/autoload.php';

$config = config('socket');

$app = new Ratchet\App($config['host'],$config['port']);

App\Providers\SocketRouteProvider::register($app);

$app->run();