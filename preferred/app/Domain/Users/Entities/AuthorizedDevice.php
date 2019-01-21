<?php

namespace Preferred\Domain\Users\Entities;

use Illuminate\Database\Eloquent\Model;
use Preferred\Infrastructure\Scopes\OwnerGlobalScopeTrait;

/**
 * Class AuthorizedDevice
 *
 * @package Preferred\Domain\Users\Entities
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
