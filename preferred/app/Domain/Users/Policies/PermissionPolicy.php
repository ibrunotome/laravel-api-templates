<?php

namespace Preferred\Domain\Users\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Preferred\Domain\Users\Entities\Permission;
use Preferred\Domain\Users\Entities\User;

class PermissionPolicy
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
        return $user->can('view any permissions');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Preferred\Domain\Users\Entities\User       $user
     * @param  \Preferred\Domain\Users\Entities\Permission $model
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
     * @param  \Preferred\Domain\Users\Entities\User $user
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
     * @param  \Preferred\Domain\Users\Entities\User       $user
     * @param  \Preferred\Domain\Users\Entities\Permission $model
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
     * @param  \Preferred\Domain\Users\Entities\User       $user
     * @param  \Preferred\Domain\Users\Entities\Permission $model
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
     * @param  \Preferred\Domain\Users\Entities\User       $user
     * @param  \Preferred\Domain\Users\Entities\Permission $model
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
     * @param  \Preferred\Domain\Users\Entities\User       $user
     * @param  \Preferred\Domain\Users\Entities\Permission $model
     *
     * @return mixed
     */
    public function forceDelete(User $user, Permission $model)
    {
        return $user->can('force delete permissions');
    }
}
