<?php

namespace App\GraphQL\Mutations;

use App\Models\Recipe;
use App\Models\Tag;
use Illuminate\Support\Facades\Gate;

final class UpdateRecipe
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args): Recipe
    {
        ['id' => $id] = $args;
        $recipe = Recipe::find($id);

        Gate::authorize('update', $recipe);

        isset($args['tags']) && $args['tags'] = json_encode(array_map(fn($value) => Tag::firstOrCreate(['name' => $value])->id, $args['tags']));

        $recipe->update($args);

        return $recipe;
    }
}
