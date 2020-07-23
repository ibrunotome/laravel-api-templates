<?php

namespace App\Domain\Audits\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class AuditPolicy
{
    use HandlesAuthorization;

    public function viewAny(): bool
    {
        return auth()->user()->hasPermissionTo('audits_list');
    }

    public function view(): bool
    {
        return auth()->user()->hasPermissionTo('audits_view');
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
