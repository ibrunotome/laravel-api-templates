<?php

namespace Preferred\Domain\Users\Entities;

use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Role extends \Spatie\Permission\Models\Role implements AuditableContract
{
    use Auditable;

    const ADMIN = 'Admin';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string'
    ];

    protected $fillable = [
        'name',
        'guard_name'
    ];
}
