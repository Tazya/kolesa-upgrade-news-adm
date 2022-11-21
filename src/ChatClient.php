<?php

namespace App;

use GuzzleHttp\Client;
use App\Config;

class ChatClient
{
    static $client;
    static $config;

    public function __construct()
    {
        self::$config = Config::load();
        self::$client = new Client(self::$config);
    }
}