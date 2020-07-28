<?php


namespace App\Http\Controllers;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController
{

    public function index()
    {
        return view('index');
    }


    public function path(Request $request): Response
    {
        return new Response($request->attributes->get('name'));
    }
}