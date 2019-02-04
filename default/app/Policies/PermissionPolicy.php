<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view a list of model.
     *
     * @param  \App\Models\User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->can('view any permissions');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User       $user
     * @param  \App\Models\Permission $model
     *
     * @return mixed
     */
    public function view(User $user, Permission $model)
    {
        return $user->can('view permissions');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('create permissions');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User       $user
     * @param  \App\Models\Permission $model
     *
     * @return mixed
     */
    public function update(User $user, Permission $model)
    {
        return $user->can('update permissions');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User       $user
     * @param  \App\Models\Permission $model
     *
     * @return mixed
     */
    public function delete(User $user, Permission $model)
    {
        return $user->can('delete permissions');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User       $user
     * @param  \App\Models\Permission $model
     *
     * @return mixed
     */
    public function restore(User $user, Permission $model)
    {
        return $user->can('restore permissions');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User       $user
     * @param  \App\Models\Permission $model
     *
     * @return mixed
     */
    public function forceDelete(User $user, Permission $model)
    {
        return $user->can('force delete permissions');
    }
}
