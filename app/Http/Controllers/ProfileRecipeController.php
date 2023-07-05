<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeCollection;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use App\Models\SaveRecipe;
use Illuminate\Support\Facades\Gate;

class ProfileRecipeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    //
    /**
     * Save specific recipe
     * @authenticated
     */
    public function store(SaveRecipe $save_recipe, Recipe $recipe, $id): RecipeResource
    {
        $recipe = $recipe->find($id) ?? abort(422, "$id not found!");

        if (!$save_recipe->firstOrCreate(['user_id' => auth()->id(), 'recipe_id' => $recipe->id])->wasRecentlyCreated) {
            abort(422, "$id already saved!");
        }

        return new RecipeResource($recipe);
    }

    /**
     * Get the saved recipes
     * @authenticated
     */
    public function saved_recipes(Recipe $recipe): RecipeCollection
    {
        $user = auth()->user();
        $array_recipe_id = array_map(fn($value) => $value['recipe_id'], $user->save_recipes->toArray());

        return new RecipeCollection(
            $recipe->latest()->whereIn('id', [...$array_recipe_id])->get()
        );
    }

    /**
     * Get the recipe created
     * @authenticated
     */
    public function index(Recipe $recipe): RecipeCollection
    {
        return new RecipeCollection($recipe->latest()->where('user_id', auth()->id())->get());
    }

    /**
     * Remove specific recipe from saved recipes
     * @authenticated
     */
    public function destroy(SaveRecipe $save_recipe, $id)
    {
        $save_recipe = $save_recipe->where('recipe_id', $id)->first() ?? abort(422, "$id not found!");

        Gate::authorize('delete', $save_recipe);

        $save_recipe->delete();

        return response()->noContent();
    }
}
