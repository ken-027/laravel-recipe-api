<?php

namespace App\GraphQL\Mutations;

use App\Http\Requests\StoreRecipeRequest;
use App\Models\Recipe;
use App\Models\Tag;

final class AddRecipe
{
    /**
     * @param  null  $_
     * @param  array{}  $args
     */
    public function __invoke($_, array $args): Recipe
    {
        $tag_ids = array_map(fn($value) => Tag::firstOrCreate(['name' => $value])->id, $args['tags']);
        $recipe = Recipe::create([
            ...$args,
            'tags' => json_encode($tag_ids),
        ]);

        $recipe->ingredients()->createMany($args['ingredients']);
        $recipe->instructions()->createMany($args['instructions']);

        return $recipe;
    }
}
