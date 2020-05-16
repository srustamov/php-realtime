<?php


namespace App\Providers;


use Ratchet\App;

class SocketRouteProvider
{
    public static function register(App $app)
    {
        require BASE_PATH.'/routes/socket.php';
    }
}