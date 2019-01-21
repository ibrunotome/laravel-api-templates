<?php

namespace Preferred\Domain\Users\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicy
{
    use HandlesAuthorization;

    public function viewAny(): bool
    {
        return auth()->user()->hasPermissionTo('profiles_list');
    }

    public function view(): bool
    {
        return auth()->user()->hasPermissionTo('profiles_view');
    }

    public function create(): bool
    {
        return false;
    }

    public function update(): bool
    {
        return auth()->user()->hasPermissionTo('profiles_update');
    }

    public function delete(): bool
    {
        return false;
    }

    public function restore(): bool
    {
        return false;
    }

    public function forceDelete(): bool
    {
        return false;
    }
}
