<?php

namespace App\Service;

class UserGlobalService
{
    public static function createTokenIfUserAuthenticated($user)
    {
        if ($user) {
            $token = $user->createToken('auth_token')->plainTextToken;
            return $token;
        }
        return null;
    }
}
