<?php

namespace App;

use GuzzleHttp\Client;
use App\Config;

class ChatClient
{
    static $client;

    public function __construct()
    {
        $config = Config::load();
        self::$client = new Client($config);
    }
}