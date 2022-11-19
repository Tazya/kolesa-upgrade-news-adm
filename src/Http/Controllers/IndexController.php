<?php

namespace App\Http\Controllers;

require_once 'ChatService.php';

use App\ChatService;
use App\WebClient;
use Slim\Http\Response;
use Slim\Http\ServerRequest;
use Slim\Views\Twig;

class IndexController
{
    function home(ServerRequest $request, Response $response)
    {
        $chatServiceClient = new WebClient();
        $chat = new ChatService($chatServiceClient);
        $isAvailable = $chat->checkHealth();

        $view = Twig::fromRequest($request);
        if ($isAvailable == "ok") {
            return $view->render($response, 'home.twig', ['name' => 'guest', 'status' => $isAvailable]);
        } else {
            return $view->render($response, 'connectError.twig', ['error' => $isAvailable]);
        }
    }
}
