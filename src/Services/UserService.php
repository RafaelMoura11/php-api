<?php

namespace App\Services;

use App\Http\JWT;
use App\Models\User;
use App\Utils\Validator;
use PDOException;

class UserService {
    public static function create(array $data) {
        try {
            $fields = Validator::validate([
                'name'      => $data['name']        ?? '',
                'email'     => $data['email']       ?? '',
                'password'  => $data['password']    ?? ''
            ]);

            $fields['password'] = password_hash($fields['password'], PASSWORD_DEFAULT);

            $user = User::save($fields);

            if (!$user) return ['error' => 'Sorry, we could not create your account.'];

            return 'User created successfully!';

        }
        catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
        catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public static function auth(array $data) {
        try {
            $fields = Validator::validate([
                'email'     => $data['email'] ?? '',
                'password'  => $data['password'] ?? ''
            ]);

            $user = User::authentication($fields);

            if (!$user) return ['error' => 'Sorry, we could not authenticate you.'];

            return JWT::generate($user);
        }
        catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
        catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public static function fetch(mixed $authorization) {
        try {
            if (isset($authorization['error'])) return ['error' => $authorization['error']];

            $userFromJWT = JWT::verify($authorization);

            if (!$userFromJWT) return ['error' => "Please, login to access this resource."];

            $user = User::findAll();
            return $user;
        }
        catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
        catch (\Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}

?>