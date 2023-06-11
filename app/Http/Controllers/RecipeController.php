<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRecipeRequest;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Http\Resources\RecipeCollection;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RecipeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['show', 'index']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(SearchRecipeRequest $request, Recipe $recipe): RecipeCollection
    {
        return new RecipeCollection(
            $recipe->search($request->get('search'))
                ->paginate($request->get('per_page'), 'recipes', $request->get('page'))
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecipeRequest $request, Recipe $recipe): RecipeResource
    {
        return new RecipeResource(
            $recipe->create($request->except(['ingredients', 'instructions']))
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe, $id): RecipeResource
    {
        return new RecipeResource($recipe->find($id ) ?? abort(422, "$id not found!"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe, $id)
    {
        $recipe = $recipe->find($id) ?? abort(422, "$id not found!");
        $recipe->delete();
        return response()->noContent();
    }
}
