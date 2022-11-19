<?php

namespace App;

use GuzzleHttp\Client;
use Noodlehaus\Config;

class WebClient
{
    public $client;

    public function __construct(object $client = NULL)
    {
        $conf = Config::load('config/local.json');

        $this->client = new Client([
            'base_uri' => $conf->get('client.base_uri'),
            'timeout' => $conf->get('client.timeout'),
            'verify' => $conf->get('client.verify'),
        ]);
    }
}

class ChatService
{
    public $chat;

    public function __construct(object $chat = NULL)
    {
        $this->chat = $chat;
    }

    function checkHealth()
    {
        try {
            $serviceResponse = $this->chat->client->request('GET', '/health', ['proxy' => 'localhost:8888']);
            $result = json_decode($serviceResponse->getBody()->getContents(), associative: true);
            $status = $result["status"];

            if ($status == "ok") {
                return $status;
            } else {
                $status = "статус сервиса не активен";
            }
        } catch (\Exception $error) {
            $status = $error->getMessage();
        }
        return $status;
    }
}
