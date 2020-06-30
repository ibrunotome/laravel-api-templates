<?php

namespace Preferred\Domain\Audits\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Audit
 *
 * @property string $old_values
 * @property string $new_values
 * @property Carbon $created_at
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
