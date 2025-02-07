<?php

namespace App\Policies;

use App\Models\User;

class TagPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        if ($user->can('view_tags')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->can('create_tags')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        if ($user->can('edit_tags')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        if ($user->can('delete_tags')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    //    public function restore(User $user): bool
    //    {
    //        if ($user->can('restore_tags')) {
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
    //        if ($user->can('force_delete_tags')) {
    //            return true;
    //        }
    //
    //        return false;
    //    }
}
