<?php

namespace App\Repository\DB;

use PDO;
use PDOException;
use Yosymfony\Toml\Toml;

class Database
{
    protected $pdo = null;
    private $DB_HOST;
    private $DB_NAME;
    private $DB_USER;
    private $DB_PASSWORD;
    private const CONFIG_PATH = '../config/config.toml';

    public function __construct()
    {
        $this->DB_HOST = $this->cfgData['db_host'];
        $this->DB_NAME = $this->cfgData['db_name'];
        $this->DB_USER = $this->cfgData['db_user'];
        $this->DB_PASSWORD = $this->cfgData['db_password'];
        $this->CONFIG_PATH = Toml::ParseFile(self::CONFIG_PATH);
        
    }

    public function connectDB()
    {
        if (is_null($this->pdo)) {
            try {
                $this->pdo = new PDO("mysql:host=" . $this->DB_HOST . ";dbname=" . $this->DB_NAME, $this->DB_USER, $this->DB_PASSWORD);
            } catch (PDOException $e) {
                print "ERROR: " . $e->getMessage();
                die();
            }

            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }

        return $this->pdo;
    }

}