<?php 

namespace App\Http\Controllers;

use Slim\Http\ServerRequest;
use Slim\Http\Response;
use SLim\Views\Twig;
use App\Model\Repository\MessageRepository;
use App\Model\Validators\MessageValidator;

class MessageController 
{
    public function new(ServerRequest $request,Response $response) 
    {
        $messData  = $request->getParsedBodyParam('message', []);

        $repo        = new MessageRepository();
        $repo->print($messData);

        $view = Twig::fromRequest($request);

        return $view->render($response, 'Message/new.twig');
    }

    public function send(ServerRequest $request,Response $response) 
    {
        $view = Twig::fromRequest($request);

        return $view->render($response, 'Message/index.twig');
    }

    public function create(ServerRequest $request, Response $response)
    {
        $repo        = new MessageRepository();
        $messData  = $request->getParsedBodyParam('message', []);

        $validator = new MessageValidator();
        $errors    = $validator->validate($messData);

        if (!empty($errors)) {
            $view = Twig::fromRequest($request);

            return $view->render($response, 'Message/new.twig', [
                'data'   => $messData,
                'errors' => $errors,
            ]);
        }
        print_r($messData);
        $repo->print($messData);

        return $response->withRedirect('/messages/new');
    }
}