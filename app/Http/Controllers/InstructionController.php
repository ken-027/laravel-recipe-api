<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstructionRequest;
use App\Http\Requests\UpdateInstructionRequest;
use App\Models\Instruction;

class InstructionController extends Controller
{
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
    public function store(StoreInstructionRequest $request)
    {
        //
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
