<?php

namespace App\Models;

use App\Scopes\OwnerGlobalScopeTrait;
use Illuminate\Database\Eloquent\Model;

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
 * @property \DateTime authorized_at
 * @property \DateTime created_at
 * @property string    user_id
 *
 * @property-read User user
 */
class AuthorizedDevice extends Model
{
    use OwnerGlobalScopeTrait;

    const UPDATED_AT = null;
    protected static $unguarded = true;
    public $incrementing = false;
    protected $dateFormat = 'Y-m-d H:i:s.u';
    protected $keyType = 'string';

    ################
    # Relationships
    ################

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
