<?php

namespace App\Policies;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Profile $model
     *
     * @return mixed
     */
    public function view(User $user, Profile $model)
    {
        return $user->can('view profiles') || $user->id === $model->user_id;
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
        return $user->can('create profiles');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Profile $model
     *
     * @return mixed
     */
    public function update(User $user, Profile $model)
    {
        return $user->can('update profiles') || $user->id === $model->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Profile $model
     *
     * @return mixed
     */
    public function delete(User $user, Profile $model)
    {
        return $user->can('delete profiles');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Profile $model
     *
     * @return mixed
     */
    public function restore(User $user, Profile $model)
    {
        return $user->can('restore profiles');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User    $user
     * @param  \App\Models\Profile $model
     *
     * @return mixed
     */
    public function forceDelete(User $user, Profile $model)
    {
        return $user->can('force delete profiles');
    }
}
