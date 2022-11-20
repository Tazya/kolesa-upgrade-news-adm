<?php

namespace App;

use GuzzleHttp\Client;
use App\Config;

class ChatClient
{
    static $client;
    
    public function __construct()
    {
        $conf = Config::load();
        self::$client = new Client($conf);
    }
}