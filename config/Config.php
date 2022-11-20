<?php

namespace Cfg;

use Yosymfony\Toml\Toml;

class Config {
    public static $chatClient = NULL;

    public static function load() {
        if (is_null(self::$chatClient)) {
            self::$chatClient = Toml::ParseFile('config\client.toml');
        } 
        return self::$chatClient;
    }
}
