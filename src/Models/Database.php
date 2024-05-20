<?php

namespace App\Models;
use PDO;

class Database {
    public static function getConnection() {
        $host = 'localhost';
        $db   = 'mydb';
        $charset = 'utf8mb4';
        $user = 'root';
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user);
        return $pdo;
    }
}

?>