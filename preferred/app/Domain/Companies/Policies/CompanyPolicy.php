<?php

namespace Preferred\Domain\Companies\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Preferred\Domain\Companies\Entities\Company;
use Preferred\Domain\Users\Entities\User;

class CompanyPolicy
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
        return $user->can('view any companies');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \Preferred\Domain\Users\Entities\User        $user
     * @param  \Preferred\Domain\Companies\Entities\Company $model
     * @return mixed
     */
    public function view(User $user, Company $model)
    {
        return $user->can('view companies');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \Preferred\Domain\Users\Entities\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('create companies');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \Preferred\Domain\Users\Entities\User        $user
     * @param  \Preferred\Domain\Companies\Entities\Company $model
     * @return mixed
     */
    public function update(User $user, Company $model)
    {
        return $user->can('update companies');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \Preferred\Domain\Users\Entities\User        $user
     * @param  \Preferred\Domain\Companies\Entities\Company $model
     * @return mixed
     */
    public function delete(User $user, Company $model)
    {
        return $user->can('delete companies');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \Preferred\Domain\Users\Entities\User        $user
     * @param  \Preferred\Domain\Companies\Entities\Company $model
     * @return mixed
     */
    public function restore(User $user, Company $model)
    {
        return $user->can('restore companies');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \Preferred\Domain\Users\Entities\User        $user
     * @param  \Preferred\Domain\Companies\Entities\Company $model
     * @return mixed
     */
    public function forceDelete(User $user, Company $model)
    {
        return $user->can('force delete companies');
    }
}
