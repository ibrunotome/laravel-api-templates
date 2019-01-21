<?php

namespace App\Models;

use App\Scopes\OwnerGlobalScopeTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LoginHistory
 *
 * @package App\Models
 *
 * @property string    id
 * @property string    device
 * @property string    platform
 * @property string    platform_version
 * @property string    browser
 * @property string    browser_version
 * @property string    ip
 * @property string    city
 * @property string    region_code
 * @property string    region_name
 * @property string    country_code
 * @property string    country_name
 * @property string    continent_code
 * @property string    continent_name
 * @property string    latitude
 * @property string    longitude
 * @property string    zipcode
 * @property string    user_id
 * @property \DateTime created_at
 *
 * @property-read User user
 */
class LoginHistory extends Model
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
