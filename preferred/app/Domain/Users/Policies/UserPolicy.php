<?php

namespace Preferred\Domain\Users\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(): bool
    {
        return auth()->user()->hasPermissionTo('users_view_any');
    }

    public function view(): bool
    {
        return auth()->user()->hasPermissionTo('users_view');
    }

    public function create(): bool
    {
        return auth()->user()->hasPermissionTo('users_create');
    }

    public function update(): bool
    {
        return auth()->user()->hasPermissionTo('users_update');
    }

    public function delete(): bool
    {
        return auth()->user()->hasPermissionTo('users_delete');
    }

    public function restore(): bool
    {
        return auth()->user()->hasPermissionTo('users_restore');
    }

    public function forceDelete(): bool
    {
        return auth()->user()->hasPermissionTo('users_force_delete');
    }
}
