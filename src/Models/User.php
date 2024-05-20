<?php

namespace App\Models;

use App\Models\Database;

class User extends Database {
    public static function save(array $data) {
        $pdo = self::getConnection();

        $stmt = $pdo->prepare("
            INSERT INTO users (name, email, password)
            VALUES (:name, :email, :password)
        ");

        $stmt->execute([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => $data['password']
        ]);

        return $pdo->lastInsertId() > 0 ? true : false;
    }
}

?>