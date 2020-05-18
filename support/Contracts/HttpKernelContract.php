<?php 

namespace Support\Contracts;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

interface HttpKernelContract 
{
    public function handle(Request $request):Response ;
}