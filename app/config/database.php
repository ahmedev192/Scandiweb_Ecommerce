<?php

namespace App\Config;

use mysqli;

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        // Load the .env file
        require_once __DIR__ . '/../../env_loader.php';
        loadEnv(__DIR__ . '/../../.env');

        $host = $_ENV['DB_HOST'];
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];
        $dbname = $_ENV['DB_NAME'];

        $this->connection = new mysqli($host, $user, $password, $dbname);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public static function getConnection()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance->connection;
    }
}
