<?php

namespace App\Database;

use PDO;

final class Connection
{
    public static function get(): PDO
    {
        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $port = getenv('DB_PORT') ?: '3307';
        $database = getenv('DB_DATABASE') ?: 'blog';
        $username = getenv('DB_USERNAME') ?: 'blog';
        $password = getenv('DB_PASSWORD') ?: 'blog';

        $dsn = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";

        return new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
}

