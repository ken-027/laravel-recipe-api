<?php

namespace App\Policies;

use App\Models\SaveRecipe;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SaveRecipePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SaveRecipe $saveRecipe): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SaveRecipe $saveRecipe): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SaveRecipe $saveRecipe): Response
    {
        return $user->id === $saveRecipe->user_id ? Response::allow() : Response::denyWithStatus(403, "Only author can remove it's saved recipe!");
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SaveRecipe $saveRecipe): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SaveRecipe $saveRecipe): bool
    {
        //
    }
}
