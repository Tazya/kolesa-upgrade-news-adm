<?php

namespace App;

use GuzzleHttp\Client;
use Cfg\Config;

class ChatClient
{
    public $client;
    
    public function __construct()
    {
        $conf = Config::load();
        $this->client = new Client($conf);
    }
}