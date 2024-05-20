<?php

namespace App\Services;

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
}

?>