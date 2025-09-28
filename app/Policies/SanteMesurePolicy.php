<?php

namespace App\Policies;

use App\Models\SanteMesure;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SanteMesurePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SanteMesure $santeMesure): bool
    {
        return $user->id === $santeMesure->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SanteMesure $santeMesure): bool
    {
        return $user->id === $santeMesure->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SanteMesure $santeMesure): bool
    {
        return $user->id === $santeMesure->user_id;
    }
}
