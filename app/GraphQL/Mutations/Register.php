<?php

namespace App\GraphQL\Mutations;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

final class Register
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args)
    {

        $user = User::create($args);

        event(new Registered($user));

        return [
            "token" => (string) Auth::login($user),
            "type" => "bearer",
            "expires_in" => Auth::factory()->getTTL() * 60
        ];
    }
}
