<?php

namespace App\Core;


use PDO;

class Connect
{
    protected static $instance = null;

    public static function getConnection()
    {
        if (self::$instance === null) {
            $config = require __DIR__ . '/../../config/config.env.php';

            $host = $config['DB_HOST'];
            $dbname = $config['DB_DATABASE'];
            $username = $config['DB_USERNAME'];
            $password = $config['DB_PASSWORD'];

            $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
            self::$instance = new PDO($dsn, $username, $password);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$instance;
    }
}
