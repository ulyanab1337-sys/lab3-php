<?php
namespace App;

use PDO;

class Db
{
    public static function connect(): PDO
    {
        $dsn = 'mysql:host=localhost;dbname=lab3;charset=utf8mb4';
        return new PDO($dsn, 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
    }
}