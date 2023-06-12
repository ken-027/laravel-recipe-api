<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use App\Models\SaveRecipe;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    //
    public function store(SaveRecipe $save_recipe, Recipe $recipe, $id): RecipeResource
    {
        $recipe = $recipe->find($id) ?? abort(422, "$id not found!");

        if (!$save_recipe->firstOrCreate(['user_id' => auth()->id(), 'recipe_id' => $recipe->id])->wasRecentlyCreated)
            abort(422, "$id already saved!");

        return new RecipeResource($recipe);
    }
}
