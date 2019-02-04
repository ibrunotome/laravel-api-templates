<?php

namespace Preferred\Domain\Users\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Preferred\Domain\Users\Entities\AuthorizedDevice;
use Preferred\Domain\Users\Entities\User;

class AuthorizedDevicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view a list of model.
     *
     * @param  \Preferred\Domain\Users\Entities\User $user
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->can('view any authorized devices');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Preferred\Domain\Users\Entities\User             $user
     * @param  \Preferred\Domain\Users\Entities\AuthorizedDevice $model
     *
     * @return mixed
     */
    public function view(User $user, AuthorizedDevice $model)
    {
        return $user->can('view authorized devices') || $user->id === $model->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Preferred\Domain\Users\Entities\User $user
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
     * @param  \Preferred\Domain\Users\Entities\User             $user
     * @param  \Preferred\Domain\Users\Entities\AuthorizedDevice $model
     *
     * @return mixed
     */
    public function update(User $user, AuthorizedDevice $model)
    {
        return $user->can('update authorized devices') || $user->id === $model->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Preferred\Domain\Users\Entities\User             $user
     * @param  \Preferred\Domain\Users\Entities\AuthorizedDevice $model
     *
     * @return mixed
     */
    public function delete(User $user, AuthorizedDevice $model)
    {
        return $user->can('delete authorized devices');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Preferred\Domain\Users\Entities\User             $user
     * @param  \Preferred\Domain\Users\Entities\AuthorizedDevice $model
     *
     * @return mixed
     */
    public function restore(User $user, AuthorizedDevice $model)
    {
        return $user->can('restore authorized devices');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Preferred\Domain\Users\Entities\User             $user
     * @param  \Preferred\Domain\Users\Entities\AuthorizedDevice $model
     *
     * @return mixed
     */
    public function forceDelete(User $user, AuthorizedDevice $model)
    {
        return $user->can('force delete authorized devices');
    }
}
