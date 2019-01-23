<?php

namespace Preferred\Domain\Users\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class LoginHistoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(): bool
    {
        return auth()->user()->hasPermissionTo('login_histories_view_any');
    }

    public function view(): bool
    {
        return auth()->user()->hasPermissionTo('login_histories_view');
    }

    public function create(): bool
    {
        return auth()->user()->hasPermissionTo('login_histories_create');
    }

    public function update(): bool
    {
        return auth()->user()->hasPermissionTo('login_histories_update');
    }

    public function delete(): bool
    {
        return auth()->user()->hasPermissionTo('login_histories_delete');
    }

    public function restore(): bool
    {
        return auth()->user()->hasPermissionTo('login_histories_restore');
    }

    public function forceDelete(): bool
    {
        return auth()->user()->hasPermissionTo('login_histories_force_delete');
    }
}
