<?php

namespace Preferred\Domain\Companies\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

/**
 * Class Company
 *
 * @property string $id
 * @property string $name
 * @property bool   $is_active
 * @property int    $max_users
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Company extends Model implements AuditableContract
{
    use Auditable;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'id'        => 'string',
        'is_active' => 'boolean',
    ];

    protected $fillable = [
        'name',
        'is_active',
        'max_users',
    ];
}
