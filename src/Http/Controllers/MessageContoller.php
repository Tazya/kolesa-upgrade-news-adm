<?php 

namespace App\Http\Controllers;

use Slim\Http\ServerRequest;
use Slim\Http\Response;
use SLim\Views\Twig;

class MessageController 
{
    public function new(ServerRequest $request,Response $response) 
    {
        $view = Twig::fromRequest($request);

        return $view->render($response, 'Message/new.twig', ['name' => 'guest']);
    }
}