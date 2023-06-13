<?php

namespace App\GraphQL\Mutations;

use App\Models\Recipe;
use Illuminate\Support\Facades\Gate;

final class DeleteRecipe
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args): Recipe
    {
        ["id" => $id] = $args;

        $recipe = Recipe::find($id);

        Gate::authorize("delete", $recipe);

        $recipe->delete();

        return $recipe;
    }
}
