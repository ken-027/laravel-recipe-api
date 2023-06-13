<?php

namespace App\GraphQL\Mutations;

use GraphQL\Error\Error;
use Illuminate\Support\Facades\Auth;

final class Login
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {
        extract($args);

        if (!$token = Auth::attempt($args)) {
            throw new Error("invalid credentials");
        }

        return [
            "token" => $token,
            "type" => "bearer",
            "expires_in" => Auth::factory()->getTTL() * 60
        ];
    }
}
