<?php

namespace Preferred\Domain\Users\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

/**
 * Class Profile
 *
 * @property string    $id
 * @property string    $anti_phishing_code
 * @property string    $email_token_confirmation
 * @property string    $google2fa_enable
 * @property string    $google2fa_secret
 * @property string    $google2fa_url
 * @property string    $name
 * @property string    $locale
 * @property string    $user_id
 * @property Carbon    $created_at
 * @property Carbon    $updated_at
 * @property-read User $user
 */
class Profile extends Model implements AuditableContract
{
    use Auditable;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'id' => 'string',
    ];

    protected $fillable = [
        'name',
        'anti_phishing_code',
        'email_token_confirmation',
        'email_token_disable_account',
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
