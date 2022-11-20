<?php

namespace App;

class ChatService
{
    public $chat;

    public function __construct(ChatClient $chat)
    {
        $this->chat = $chat;
    }

    function checkHealth(): bool
    {
        $serviceResponse = $this->chat::$client->request('GET', '/health', ['proxy' => 'localhost:8888']);
        $result = json_decode($serviceResponse->getBody()->getContents(), associative: true);
        if ($result["status"] === "ok") {
            return true;
        } else {
            throw new \Exception("Неправильный статус сервера бота");
        }
    }
}
