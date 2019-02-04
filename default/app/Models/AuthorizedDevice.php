<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

/**
 * Class AuthorizedDevice
 *
 * @package App\Models
 *
 * @property string    id
 * @property string    device
 * @property string    platform
 * @property string    platform_version
 * @property string    browser
 * @property string    browser_version
 * @property string    city
 * @property string    country_name
 * @property string    authorization_token
 * @property Carbon    authorized_at
 * @property Carbon    created_at
 * @property Carbon    updated_at
 * @property string    user_id
 *
 * @property-read User user
 */
class AuthorizedDevice extends Model implements AuditableContract
{
    use Auditable;
    use SoftDeletes;

    protected static $unguarded = true;

    public $incrementing = false;

    protected $dates = ['deleted_at'];

    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string',
    ];

    ################
    # Relationships
    ################

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
