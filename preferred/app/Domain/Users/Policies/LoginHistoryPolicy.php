<?php

namespace Preferred\Domain\Users\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Preferred\Domain\Users\Entities\LoginHistory;
use Preferred\Domain\Users\Entities\User;

class LoginHistoryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view a list of model.
     *
     * @param  \Preferred\Domain\Users\Entities\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->can('view any login histories');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Preferred\Domain\Users\Entities\User         $user
     * @param  \Preferred\Domain\Users\Entities\LoginHistory $model
     * @return mixed
     */
    public function view(User $user, LoginHistory $model)
    {
        return $user->can('view login histories') || $user->id === $model->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Preferred\Domain\Users\Entities\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Preferred\Domain\Users\Entities\User         $user
     * @param  \Preferred\Domain\Users\Entities\LoginHistory $model
     * @return mixed
     */
    public function update(User $user, LoginHistory $model)
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Preferred\Domain\Users\Entities\User         $user
     * @param  \Preferred\Domain\Users\Entities\LoginHistory $model
     * @return mixed
     */
    public function delete(User $user, LoginHistory $model)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Preferred\Domain\Users\Entities\User         $user
     * @param  \Preferred\Domain\Users\Entities\LoginHistory $model
     * @return mixed
     */
    public function restore(User $user, LoginHistory $model)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Preferred\Domain\Users\Entities\User         $user
     * @param  \Preferred\Domain\Users\Entities\LoginHistory $model
     * @return mixed
     */
    public function forceDelete(User $user, LoginHistory $model)
    {
        return false;
    }
}
