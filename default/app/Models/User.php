<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 *
 * @package App\Models
 *
 * @property string                id
 * @property string                email
 * @property bool                  is_active
 * @property string                email_verified_at
 * @property string                locale
 * @property \DateTime             created_at
 * @property \DateTime             updated_at
 *
 * @property-read AuthorizedDevice authorizedDevices
 * @property-read LoginHistory     loginHistories
 * @property-read Profile          profile
 */
class User extends Authenticatable implements JWTSubject, AuditableContract, MustVerifyEmail
{
    use Auditable;
    use Notifiable;

    public $incrementing = false;

    protected $dateFormat = 'Y-m-d H:i:s.u';

    protected $keyType = 'string';

    protected $casts = [
        'id'                => 'string',
        'is_active'         => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    protected $fillable = [
        'email',
        'password',
        'email_verified_at',
        'locale',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The channels the user receives notification broadcasts on.
     *
     * @return string
     */
    public function receivesBroadcastNotificationsOn()
    {
        return 'users.' . $this->id;
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        if (!empty($value)) {
            $value = Carbon::parse($value);

            $milliseconds = bcdiv($value->format('u'), 1000, 0);
            return $value->format('Y-m-d\TH:i:s') . '.' . $milliseconds . 'Z';
        }

        return null;
    }

    ################
    # Relationships
    ################

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function loginHistories()
    {
        return $this->hasMany(LoginHistory::class)->orderBy('created_at', 'desc')->limit(10);
    }

    public function authorizedDevices()
    {
        return $this->hasMany(AuthorizedDevice::class)
            ->whereNotNull('authorized_at')
            ->orderBy('created_at', 'desc');
    }

    public function unreadNotifications()
    {
        return $this->notifications()->whereNull('read_at');
    }

    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')
            ->whereNotNull('read_at')
            ->orderBy('created_at', 'desc')
            ->limit(15);
    }
}
