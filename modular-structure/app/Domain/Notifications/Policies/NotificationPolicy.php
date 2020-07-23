<?php

namespace App\Domain\Notifications\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy
{
    use HandlesAuthorization;

    public function viewAny(): bool
    {
        return auth()->user()->hasPermissionTo('notifications_list');
    }

    public function view(): bool
    {
        return auth()->user()->hasPermissionTo('notifications_view');
    }

    public function create(): bool
    {
        return false;
    }

    public function update(): bool
    {
        return false;
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
