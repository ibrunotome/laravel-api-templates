<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

/**
 * App\Models\Company
 *
 * @property string                                                            $id
 * @property string                                                            $name
 * @property bool                                                              $is_active
 * @property int                                                               $max_users
 * @property \Illuminate\Support\Carbon|null                                   $created_at
 * @property \Illuminate\Support\Carbon|null                                   $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Audit[] $audits
 * @property-read int|null                                                     $audits_count
 * @method static Builder|Company newModelQuery()
 * @method static Builder|Company newQuery()
 * @method static Builder|Company query()
 * @method static Builder|Company whereCreatedAt($value)
 * @method static Builder|Company whereId($value)
 * @method static Builder|Company whereIsActive($value)
 * @method static Builder|Company whereMaxUsers($value)
 * @method static Builder|Company whereName($value)
 * @method static Builder|Company whereUpdatedAt($value)
 * @mixin \Eloquent
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
