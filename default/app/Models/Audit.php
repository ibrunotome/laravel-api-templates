<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Audit
 *
 * @package App\Models
 *
 * @property \DateTime created_at
 * @property \DateTime updated_at
 */
class Audit extends Model implements \OwenIt\Auditing\Contracts\Audit
{
    use \OwenIt\Auditing\Audit;

    const UPDATED_AT = null;
    protected static $unguarded = true;
    public $incrementing = false;
    protected $dateFormat = 'Y-m-d H:i:s.u';
    protected $keyType = 'string';
    protected $casts = [
        'id'         => 'string',
        'old_values' => 'json',
        'new_values' => 'json',
    ];
}
