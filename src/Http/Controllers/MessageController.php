<?php

namespace App\Http\Controllers;

use Slim\Http\ServerRequest;
use Slim\Http\Response;
use SLim\Views\Twig;
use App\Model\Validators\MessageValidator;
use App\Repository\MessageRepository;
use GuzzleHttp\Client;

class MessageController
{
    public function new(ServerRequest $request, Response $response)
    {
        $view = Twig::fromRequest($request);

        return $view->render($response, 'Message/index.twig');
    }

    public function create(ServerRequest $request, Response $response)
    {
        $view = Twig::fromRequest($request);
        $messageData  = $request->getParsedBodyParam('message', []);
        $validator = new MessageValidator();
        $errors    = $validator->validate($messageData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'Message/index.twig', [
                'data'   => $messageData,
                'errors' => $errors,
            ]);
        }

        $data = [
            'proxy' => 'localhost:8888',
            'body' => json_encode($messageData),
        ];
        $client = new Client();
        try {
            $serviceResponse = $client->request('POST', 'http://localhost/messages/sendToAll', $data);
            $result = json_decode($serviceResponse->getBody()->getContents(), associative: true);
            
            if ($result["status"] != "ok"){
                throw new \Exception($result["error"]);
            }

        } catch (\Exception $exc) {
            return $view->render($response, 'sendError.twig', ['error' => $exc->getMessage()]);
        };

        $repo = new MessageRepository();
        $repo->create($messageData);
        return $view->render($response, 'Message/index.twig', ['messages' => [$messageData]]);
    }

    public function allMessages(ServerRequest $request, Response $response)
    {
        $repo = new MessageRepository();
        $messages = $repo->getAll();

        $view = Twig::fromRequest($request);

        return $view->render($response, 'Message/listOfMsg.twig', ["messages" => $messages]);
    }
}
