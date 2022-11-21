<?php

namespace App;

use App\Config;

class ChatService
{
    static $config;
    public $chat;

    public function __construct(ChatClient $chat)
    {
        $this->chat = $chat;
        self::$config = Config::load();
    }

    function checkHealth(): bool
    {
        $serviceResponse = $this->chat::$client->request('GET', self::$config["is_avaible_url"], ['proxy' => self::$config["proxy"]]);
        $result = json_decode($serviceResponse->getBody()->getContents(), associative: true);
        if ($result["status"] === "ok") {
            return true;
        } else {
            throw new \Exception("Неправильный статус сервера бота");
        }
    }

    function sendMessage(array $messageData)
    {
        $data = [
            'proxy' => self::$config["proxy"],
            'body' => json_encode($messageData),
        ];
        
        $serviceResponse = $this->chat::$client->request('POST', self::$config["send_message_url"], $data);
        $result = json_decode($serviceResponse->getBody()->getContents(), associative: true);
        if ($result["status"] != "ok") {
            throw new \Exception($result["error"]);
        }
    }
}
