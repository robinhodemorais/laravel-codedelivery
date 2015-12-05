<?php
/**
 * Created by PhpStorm.
 * User: Robinho de Morais
 * Date: 03/09/2015
 * Time: 22:12
 */

namespace CodeDelivery\OAuth2;

Use Illuminate\Support\Facades\Auth;

class PasswordVerifier
{
    public function verify($username, $password)
    {
        $credentials = [
            'email'    => $username,
            'password' => $password,
        ];

        if (Auth::once($credentials)) {
            return Auth::user()->id;
        }

        return false;
    }
}