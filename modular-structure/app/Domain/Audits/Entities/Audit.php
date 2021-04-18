<?php

namespace App\Domain\Audits\Entities;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Domain\Audits\Entities\Audit
 *
 * @property string $id
 * @property string|null $user_id
 * @property string|null $user_type
 * @property string $event
 * @property string $auditable_id
 * @property string $auditable_type
 * @property array|null $old_values
 * @property array|null $new_values
 * @property string|null $url
 * @property string|null $ip_address
 * @property string|null $user_agent
 * @property string|null $tags
 * @property \Illuminate\Support\Carbon $created_at
 * @property-read Model|\Eloquent $auditable
 * @property-read Model|\Eloquent $user
 * @method static Builder|Audit newModelQuery()
 * @method static Builder|Audit newQuery()
 * @method static Builder|Audit query()
 * @method static Builder|Audit whereAuditableId($value)
 * @method static Builder|Audit whereAuditableType($value)
 * @method static Builder|Audit whereCreatedAt($value)
 * @method static Builder|Audit whereEvent($value)
 * @method static Builder|Audit whereId($value)
 * @method static Builder|Audit whereIpAddress($value)
 * @method static Builder|Audit whereNewValues($value)
 * @method static Builder|Audit whereOldValues($value)
 * @method static Builder|Audit whereTags($value)
 * @method static Builder|Audit whereUrl($value)
 * @method static Builder|Audit whereUserAgent($value)
 * @method static Builder|Audit whereUserId($value)
 * @method static Builder|Audit whereUserType($value)
 * @mixin \Eloquent
 */
class Audit extends Model implements \OwenIt\Auditing\Contracts\Audit
{
    use \OwenIt\Auditing\Audit;

    public const UPDATED_AT = null;

    protected static $unguarded = true;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'id'         => 'string',
        'old_values' => 'json',
        'new_values' => 'json',
    ];

    public function getTable(): string
    {
        return 'audits';
    }

    public function getConnectionName()
    {
        return config('database.default');
    }
}
