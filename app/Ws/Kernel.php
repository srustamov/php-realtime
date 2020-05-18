<?php 

namespace App\Ws;

use Ratchet\App;

class Kernel 
{
    public function handle(App $app)
    {
        require base_path('routes/socket.php');

        return $app;
    }
}