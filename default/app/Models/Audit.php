<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Audit
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Audit extends Model implements \OwenIt\Auditing\Contracts\Audit
{
    use \OwenIt\Auditing\Audit;

    public const UPDATED_AT = null;

    protected static $unguarded = true;

    public $incrementing = false;

    protected $dateFormat = 'Y-m-d H:i:s.u';

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
