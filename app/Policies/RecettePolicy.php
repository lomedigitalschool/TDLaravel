<?php

namespace App\Policies;

use App\Models\Recette;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RecettePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // The user can only view their own recettes
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Recette $recette): bool
    {
        //return $user->id === $recette->user_id; // The user can only view their own recettes
        return true; // Allow all users to view recettes
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Allow all authenticated users to create recettes
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Recette $recette): bool
    {
        return $user->id === $recette->user_id; // The user can only update their own recettes
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Recette $recette): bool
    {
        return $user->id === $recette->user_id; // The user can only delete their own recettes
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Recette $recette): bool
    {
        return $user->id === $recette->user_id; // The user can only restore their own recettes
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Recette $recette): bool
    {
        return $user->id === $recette->user_id; // The user can only permanently delete their own recettes
    }
}
