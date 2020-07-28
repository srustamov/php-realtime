<?php


namespace App\Providers;

use Support\Contracts\ProviderContract;
use Support\Route;


class HttpRouteProvider implements ProviderContract
{
    private $namespace = 'App\\Http\\Controllers\\';

    public function register()
    {
        Route::setNamespace($this->namespace);

        require base_path('routes/web.php');
    }
}
