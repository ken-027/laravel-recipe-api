<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIngredientRequest;
use App\Http\Requests\UpdateIngredientRequest;
use App\Http\Resources\IngredientResource;
use App\Http\Resources\RecipeResource;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Support\Facades\Gate;

class IngredientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * Get all ingredients from specific recipe
     */
    public function index(Ingredient $ingredient, $recipe_id)
    {
        $recipe = Recipe::find($recipe_id) ?? abort(422, "Recipe $recipe_id not found!");

        return IngredientResource::collection($ingredient->where('recipe_id', $recipe->id)->get());
    }

    /**
     * Add new ingredient from a specific recipe
     * @authenticated
     */
    public function store(StoreIngredientRequest $request, $recipe_id): RecipeResource
    {
        $recipe = Recipe::find($recipe_id) ?? abort(422, "Recipe $recipe_id not found!");

        Gate::authorize('create', $recipe);

        if (!Ingredient::firstOrCreate([...$request->validated(), 'recipe_id' => $recipe_id])->wasRecentlyCreated) {
            abort(422, 'already created this ingredient!');
        }

        return new RecipeResource($recipe);
    }

    /**
     * Get specific ingredient from specific recipe
     */
    public function show(Ingredient $ingredient, $recipe_id, $id): IngredientResource
    {
        Recipe::find($recipe_id) ?? abort(422, "Recipe $recipe_id not found!");

        return new IngredientResource($ingredient->find($id) ?? abort(422, "Ingredients $id not found!"));
    }

    /**
     * Update specific ingredient from specific recipe
     * @authenticated
     */
    public function update(UpdateIngredientRequest $request, $recipe_id, $id): IngredientResource
    {
        Recipe::find($recipe_id) ?? abort(422, "Recipe $recipe_id not found!");

        $ingredient = Ingredient::find($id) ?? abort(422, "Ingredient $id not found!");

        Gate::authorize('update', $ingredient);

        $ingredient->update($request->validated());

        return new IngredientResource($ingredient);
    }

    /**
     * Remove ingredients from it's recipe
     * @authenticated
     */
    public function destroy(Ingredient $ingredient, $recipe_id, $id)
    {
        Recipe::find($recipe_id) ?? abort(422, "Recipe $recipe_id not found!");

        $instruction = $ingredient->find($id) ?? abort(422, "Ingredient $id not found!");

        Gate::authorize('delete', $instruction);

        $instruction->delete();

        return response()->noContent();
    }
}
