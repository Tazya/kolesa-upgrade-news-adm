<?php

namespace App\Http\Controllers;

use Slim\Http\Response;
use Slim\Http\ServerRequest;

class IndexController 
{
    public function home($request, $response) 
    {
        $response->getBody()->write('Hello^-^');
        return $response;
    }
}