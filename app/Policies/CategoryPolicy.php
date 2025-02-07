<?php

namespace App\Policies;

use App\Models\User;

class CategoryPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        if ($user->can('view_categories')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can('create_categories')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        if ($user->can('edit_categories')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        if ($user->can('delete_categories')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    //    public function restore(User $user): bool
    //    {
    //        if ($user->can('restore_categories')) {
    //            return true;
    //        }
    //
    //        return false;
    //    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    //    public function forceDelete(User $user): bool
    //    {
    //        if ($user->can('force_delete_categories')) {
    //            return true;
    //        }
    //
    //        return false;
    //    }
}
