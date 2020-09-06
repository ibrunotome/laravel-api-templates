<?php

namespace App\Domain\Users\Policies;

use App\Domain\Users\Entities\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
        return $user->can('view any users');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Domain\Users\Entities\User $user
     * @param \App\Domain\Users\Entities\User $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return $user->can('view users') || $user->id === $model->id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Domain\Users\Entities\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('create users');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Domain\Users\Entities\User $user
     * @param \App\Domain\Users\Entities\User $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $user->can('update users') || $user->id === $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Domain\Users\Entities\User $user
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->can('delete users');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Domain\Users\Entities\User $user
     * @return mixed
     */
    public function restore(User $user)
    {
        return $user->can('restore users');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Domain\Users\Entities\User $user
     * @return mixed
     */
    public function forceDelete(User $user)
    {
        return $user->can('force delete users');
    }
}
