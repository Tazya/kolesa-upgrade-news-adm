<?php 

namespace App\Http\Controllers;

use Slim\Http\ServerRequest;
use Slim\Http\Response;
use SLim\Views\Twig;
use App\Model\Validators\MessageValidator;

class MessageController 
{
    public function new(ServerRequest $request,Response $response) 
    {
        $view = Twig::fromRequest($request);

        return $view->render($response, 'Message/new.twig');
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

        return $view->render($response,'Message/index.twig', ['messages'=> [$messageData]]);
    }
}