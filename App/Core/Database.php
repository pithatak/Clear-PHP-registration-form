<?php
declare(strict_types=1);

namespace App\Core;

use PDO;

class Database
{
    private static PDO $connection;

    public static function getConnection(): PDO
    {
        if (!isset(self::$connection)) {
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