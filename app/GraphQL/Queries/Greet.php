<?php

namespace App\GraphQL\Queries;

final class Greet
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args): string
    {
        $user = auth()->user();
        return "Welcome {$args['name']}, to the graphql! from $user->name";
    }
}
