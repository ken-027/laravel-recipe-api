<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstructionRequest;
use App\Http\Requests\UpdateInstructionRequest;
use App\Http\Resources\InstructionResource;
use App\Http\Resources\RecipeResource;
use App\Models\Instruction;
use App\Models\Recipe;
use Illuminate\Support\Facades\Gate;

class InstructionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Instruction $instruction, $recipe_id)
    {
        $recipe = Recipe::find($recipe_id) ?? abort(422, "Recipe $recipe_id not found!");

        return InstructionResource::collection($instruction->latest('step_number')->where('recipe_id', $recipe->id)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInstructionRequest $request, $recipe_id): RecipeResource
    {
        $recipe = Recipe::find($recipe_id) ?? abort(422, "Recipe $recipe_id not found!");

        Gate::authorize('create', $recipe);

        if (!Instruction::firstOrCreate([...$request->validated(), 'recipe_id' => $recipe_id])->wasRecentlyCreated)
            abort(422, 'already created this step!');

        return new RecipeResource($recipe);
    }

    /**
     * Display the specified resource.
     */
    public function show(Instruction $instruction, $recipe_id, $id)
    {
        Recipe::find($recipe_id) ?? abort(422, "Recipe $recipe_id not found!");
        return new InstructionResource($instruction->find($id) ?? abort(422, "Instruction $id not found!"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstructionRequest $request, $recipe_id, $id): InstructionResource
    {
        Recipe::find($recipe_id) ?? abort(422, "Recipe $recipe_id not found!");

        $instruction = Instruction::find($id) ?? abort(422, "Instruction $id not found!");

        Gate::authorize('update', $instruction);

        $instruction->update($request->validated());
        return new InstructionResource($instruction);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instruction $instruction, $recipe_id, $id)
    {
        Recipe::find($recipe_id) ?? abort(422, "Recipe $recipe_id not found!");

        $instruction = $instruction->find($id) ?? abort(422, "Instruction $id not found!");

        Gate::authorize('delete', $instruction);

        $instruction->delete();

        return response()->noContent();
    }
}
