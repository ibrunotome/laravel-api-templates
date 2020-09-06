<?php

namespace App\Domain\Users\Policies;

use App\Domain\Users\Entities\LoginHistory;
use App\Domain\Users\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LoginHistoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view a list of model.
     *
     * @param \App\Domain\Users\Entities\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->can('view any login histories');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Domain\Users\Entities\User         $user
     * @param \App\Domain\Users\Entities\LoginHistory $model
     * @return mixed
     */
    public function view(User $user, LoginHistory $model)
    {
        return $user->can('view login histories') || $user->id === $model->user_id;
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
     * @return mixed
     */
    public function update()
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return mixed
     */
    public function delete()
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return mixed
     */
    public function restore()
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return mixed
     */
    public function forceDelete()
    {
        return false;
    }
}
