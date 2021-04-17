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
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view any authorized devices');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AuthorizedDevice $model): bool
    {
        return $user->can('view authorized devices') || $user->id === $model->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AuthorizedDevice $model): bool
    {
        return $user->can('update authorized devices') || $user->id === $model->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->can('delete authorized devices');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return $user->can('restore authorized devices');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return $user->can('force delete authorized devices');
    }
}
