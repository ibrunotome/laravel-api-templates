<?php

namespace App\Policies;

use App\Models\LoginHistory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LoginHistoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User         $user
     * @param  \App\Models\LoginHistory $model
     *
     * @return mixed
     */
    public function view(User $user, LoginHistory $model)
    {
        return $user->can('view login histories') || $user->id === $model->user_id;
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
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User         $user
     * @param  \App\Models\LoginHistory $model
     *
     * @return mixed
     */
    public function update(User $user, LoginHistory $model)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User         $user
     * @param  \App\Models\LoginHistory $model
     *
     * @return mixed
     */
    public function delete(User $user, LoginHistory $model)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User         $user
     * @param  \App\Models\LoginHistory $model
     *
     * @return mixed
     */
    public function restore(User $user, LoginHistory $model)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User         $user
     * @param  \App\Models\LoginHistory $model
     *
     * @return mixed
     */
    public function forceDelete(User $user, LoginHistory $model)
    {
        return false;
    }
}
