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
     * Display a listing of the resource.
     */
    public function index(Ingredient $ingredient, $recipe_id)
    {
        $recipe = Recipe::find($recipe_id) ?? abort(422, "Recipe $recipe_id not found!");

        return IngredientResource::collection($ingredient->where('recipe_id', $recipe->id)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIngredientRequest $request, $recipe_id): RecipeResource
    {
        $recipe = Recipe::find($recipe_id) ?? abort(422, "Recipe $recipe_id not found!");

        Gate::authorize('create', $recipe);

        if (!Ingredient::firstOrCreate([...$request->validated(), 'recipe_id' => $recipe_id])->wasRecentlyCreated)
            abort(422, 'already created this ingredient!');

        return new RecipeResource($recipe);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ingredient $ingredient, $recipe_id, $id): IngredientResource
    {
        Recipe::find($recipe_id) ?? abort(422, "Recipe $recipe_id not found!");
        return new IngredientResource($ingredient->find($id) ?? abort(422, "Ingredients $id not found!"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIngredientRequest $request, Ingredient $ingredient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
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
