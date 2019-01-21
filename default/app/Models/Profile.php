<?php

namespace App\Models;

use App\Scopes\OwnerGlobalScopeTrait;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

/**
 * Class Profile
 *
 * @package App\Models
 *
 * @property string    id
 * @property string    anti_phishing_code
 * @property string    email_token_confirmation
 * @property string    google2fa_enable
 * @property string    google2fa_secret
 * @property string    google2fa_url
 * @property string    name
 * @property string    user_id
 * @property \DateTime created_at
 * @property \DateTime updated_at
 *
 * @property-read User user
 */
class Profile extends Model implements AuditableContract
{
    use Auditable;
    use OwnerGlobalScopeTrait;

    public $incrementing = false;

    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string',
    ];

    protected $fillable = [
        'name',
        'anti_phishing_code',
        'email_token_confirmation',
        'email_token_disable_account',
        'google2fa_enable',
        'google2fa_secret',
        'google2fa_url',
        'user_id',
    ];

    ################
    # Relationships
    ################

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
