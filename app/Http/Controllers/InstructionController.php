<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstructionRequest;
use App\Http\Requests\UpdateInstructionRequest;
use App\Http\Resources\RecipeResource;
use App\Models\Instruction;
use App\Models\Recipe;

class InstructionController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInstructionRequest $request, $recipe_id): RecipeResource
    {
        $recipe = Recipe::find($recipe_id) ?? abort(422, "Recipe $recipe_id not found!");
        if (!Instruction::firstOrCreate([...$request->validated(), 'recipe_id' => $recipe_id])->wasRecentlyCreated)
            abort(422, 'already created this step!');
        return new RecipeResource($recipe);
    }

    /**
     * Display the specified resource.
     */
    public function show(Instruction $instruction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInstructionRequest $request, Instruction $instruction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instruction $instruction)
    {
        //
    }
}
