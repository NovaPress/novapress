<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        if ($user->can('view_users')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can('create_users')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        if ($user->can('edit_users')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        if ($user->can('delete_users')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    //    public function restore(User $user, User $model): bool
    //    {
    //        return false;
    //    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    //    public function forceDelete(User $user, User $model): bool
    //    {
    //        return false;
    //    }
}
