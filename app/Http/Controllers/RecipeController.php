<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRecipeRequest;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Requests\UpdateRecipeRequest;
use App\Http\Resources\RecipeCollection;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class RecipeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['show', 'index']);
    }

    /**
     * Get the list of recipes
     */
    public function index(SearchRecipeRequest $request, Recipe $recipe): RecipeCollection
    {
        $search = $request->get('search');
        $per_page = $request->get('per_page');
        $page = $request->get('page');

        return new RecipeCollection(
            Cache::remember("recipes.$search.$per_page.$page", 60, fn() => $recipe->search($search)
                    ->paginate($per_page, 'recipes', $page))
        );
    }

    /**
     * Create new recipe
     * @authenticated
     */
    public function store(StoreRecipeRequest $request, Recipe $recipe): RecipeResource
    {
        return new RecipeResource(
            $recipe->create($request->except(['ingredients', 'instructions']))
        );
    }

    /**
     * Display the specified recipe
     */
    public function show(Recipe $recipe, $id): RecipeResource
    {
        return new RecipeResource($recipe->find($id) ?? abort(422, "$id not found!"));
    }

    /**
     * Update specified recipe
     * @authenticated
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe, $id): RecipeResource
    {
        $recipe = $recipe->find($id) ?? abort(422, "$id not found!");

        $recipe->offsetUnset('instructions');
        $recipe->offsetUnset('ingredients');

        Gate::authorize('update', $recipe);

        $recipe->update($request->validated());

        return new RecipeResource($recipe);
    }

    /**
     * Delete the specified recipe
     * @authenticated
     */
    public function destroy(Recipe $recipe, $id)
    {
        $recipe = $recipe->find($id) ?? abort(422, "$id not found!");

        Gate::authorize('delete', $recipe);

        $recipe->delete();

        return response()->noContent();
    }
}
