<?php

namespace App\Core;

use PDO;

class Database
{
    private static $connection;

    public static function getConnection()
    {
        if (!self::$connection) {
            $config = require __DIR__ . '/../../config/database.php';

            self::$connection = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8",
                $config['user'],
                $config['password']
            );
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
    }
}