<?php

namespace App\Policies;

use App\Models\Instruction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class InstructionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    // public function viewAny(User $user): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can view the model.
     */
    // public function view(User $user, Instruction $instruction): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Instruction $instruction): Response
    {
        return $user->id === $instruction->recipe->user_id ? Response::allow() : Response::denyWithStatus(403, "Only author can add this instruction");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Instruction $instruction): Response
    {
        return $user->id === $instruction->recipe->user_id ? Response::allow() : Response::denyWithStatus(403, "Only author can update this instruction");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Instruction $instruction): Response
    {
        return $user->id === $instruction->recipe->user_id ? Response::allow() : Response::denyWithStatus(403, "Only author can delete this instruction");
    }

    /**
     * Determine whether the user can restore the model.
     */
    // public function restore(User $user, Instruction $instruction): bool
    // {
    //     //
    // }

    /**
     * Determine whether the user can permanently delete the model.
     */
    // public function forceDelete(User $user, Instruction $instruction): bool
    // {
    //     //
    // }
}
