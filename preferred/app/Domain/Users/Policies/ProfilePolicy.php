<?php

namespace Preferred\Domain\Users\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicy
{
    use HandlesAuthorization;

    public function viewAny(): bool
    {
        return auth()->user()->hasPermissionTo('profiles_view_any');
    }

    public function view(): bool
    {
        return auth()->user()->hasPermissionTo('profiles_view');
    }

    public function create(): bool
    {
        return auth()->user()->hasPermissionTo('profiles_create');
    }

    public function update(): bool
    {
        return auth()->user()->hasPermissionTo('profiles_update');
    }

    public function delete(): bool
    {
        return auth()->user()->hasPermissionTo('profiles_delete');
    }

    public function restore(): bool
    {
        return auth()->user()->hasPermissionTo('profiles_restore');
    }

    public function forceDelete(): bool
    {
        return auth()->user()->hasPermissionTo('profiles_force_delete');
    }
}
