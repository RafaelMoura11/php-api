<?php

namespace App\Models;
use PDO;

class Database {
    public static function getConnection() {
        $host = 'localhost';
        $db   = 'mydb';
        $charset = 'utf8mb4';
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset");
        return $pdo;
    }
}

?>