<?php

namespace App\Http\Controllers;

use Slim\Http\Response;
use Slim\Http\ServerRequest;
use Slim\Views\Twig;
use GuzzleHttp\Client;

class IndexController
{
    private $client;

    function initializeClient(): void
    {
        $client = new Client([
            'base_uri' => 'http://localhost',
            'timeout' => 2.0,
            'verify' => false,
        ]);
        $this->client = $client;
    }

    function home(ServerRequest $request, Response $response)
    {
        $view = Twig::fromRequest($request);
        $this->initializeClient();

        try {
            $serviceResponse = $this->client->request('GET', '/health', ['proxy' => 'localhost:8888']);
            $result = json_decode($serviceResponse->getBody()->getContents(), associative: true);
            $status = $result["status"];

            if ($status == "ok") {
                return $view->render($response, 'home.twig', ['name' => 'guest', 'status' => $status]);
            } else {
                $errMessage = "статус сервиса не активен";
            };
        } catch (\Exception $error) {
            $errMessage = $error->getMessage();
        }

        return $view->render($response, 'connectError.twig', ['error' => $errMessage]);
    }
}
