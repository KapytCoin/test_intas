<?php

namespace App\Service;

use PDO;

final class ConnectionService
{
    private static ?ConnectionService $conn = null;

    protected function __construct()
    {
    }

    public function connect(): PDO
    {
        // В host= нужно указать hostname или container_id постгрес контейнера 
        $dsn = 'pgsql:host=c518a0295d45;port=5432;dbname=postgres';
        $user = 'postgres';
        $password = '123';

        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    public static function get(): ?ConnectionService
    {
        if (null === static::$conn) {
            static::$conn = new self();
        }

        return static::$conn;
    }
}
