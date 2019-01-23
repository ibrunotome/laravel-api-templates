<?php

namespace Preferred\Domain\Users\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class AuthorizedDevicePolicy
{
    use HandlesAuthorization;

    public function viewAny(): bool
    {
        return auth()->user()->hasPermissionTo('authorized_devices_view_any');
    }

    public function view(): bool
    {
        return auth()->user()->hasPermissionTo('authorized_devices_view');
    }

    public function create(): bool
    {
        return auth()->user()->hasPermissionTo('authorized_devices_create');
    }

    public function update(): bool
    {
        return auth()->user()->hasPermissionTo('authorized_devices_update');
    }

    public function delete(): bool
    {
        return auth()->user()->hasPermissionTo('authorized_devices_delete');
    }

    public function restore(): bool
    {
        return auth()->user()->hasPermissionTo('authorized_devices_restore');
    }

    public function forceDelete(): bool
    {
        return auth()->user()->hasPermissionTo('authorized_devices_force_delete');
    }
}
