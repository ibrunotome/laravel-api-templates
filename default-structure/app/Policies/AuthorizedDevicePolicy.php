<?php

namespace App\Policies;

use App\Models\AuthorizedDevice;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AuthorizedDevicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view a list of model.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->can('view any authorized devices');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User             $user
     * @param \App\Models\AuthorizedDevice $model
     * @return mixed
     */
    public function view(User $user, AuthorizedDevice $model)
    {
        return $user->can('view authorized devices') || $user->id === $model->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @return mixed
     */
    public function create()
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User             $user
     * @param \App\Models\AuthorizedDevice $model
     * @return mixed
     */
    public function update(User $user, AuthorizedDevice $model)
    {
        return $user->can('update authorized devices') || $user->id === $model->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->can('delete authorized devices');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function restore(User $user)
    {
        return $user->can('restore authorized devices');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return $user->can('force delete authorized devices');
    }
}
