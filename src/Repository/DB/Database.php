<?php

namespace App\Repository\DB;

use Yosymfony\Toml\Toml;

class Database
{
    private const CONFIG_PATH = 'config/local.toml';
    private static ?Database $database = null;
    private \PDO $pdo;

    public function __construct(array $config)
    {
        if (!isset($config['db_host'], $config['db_name'], $config['db_user'], $config['db_password'])) {
            throw new \Exception('Wrong Database config');
        }

        if ($config['db_password'] == "") {
            $password = file("config/DBpassword.txt"); 
            $config['db_password'] = $password[0];
        }

        $dsn = sprintf('mysql:host=%s;dbname=%s', $config['db_host'], $config['db_name']);
        $this->pdo = new \PDO($dsn, $config['db_user'], $config['db_password']);
    }

    public static function getConnection(): Database
    {
        if (self::$database) {
            return self::$database;
        }

        self::$database = new self(Toml::ParseFile(self::CONFIG_PATH));

        return self::$database;
    }

    public function getPdo(): \PDO
    {
        return $this->pdo;
    }
}
