<?php

namespace App;

use Yosymfony\Toml\Toml;

class Config {
    private const CONFIG_PATH = 'config/local.toml';
    private static $chatClient = NULL;

    public static function load() {
        if (is_null(self::$chatClient)) {
            self::$chatClient = Toml::ParseFile(self::CONFIG_PATH);
        } 
        return self::$chatClient;
    }
}
