<?php

namespace Preferred\Domain\Users\Entities;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Preferred\Domain\Users\Notifications\ResetPasswordNotification;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 *
 * @property string                    $id
 * @property string                    $email
 * @property bool                      $is_active
 * @property Carbon                    $email_verified_at
 * @property string                    $locale
 * @property Carbon                    $created_at
 * @property Carbon                    $updated_at
 * @property-read AuthorizedDevice     $authorizedDevices
 * @property-read LoginHistory         $loginHistories
 * @property-read Profile              $profile
 * @property-read DatabaseNotification $notifications
 * @property-read DatabaseNotification $unreadNotificatinos
 */
class User extends Authenticatable implements JWTSubject, AuditableContract, HasLocalePreference, MustVerifyEmail
{
    use Auditable;
    use HasRoles;
    use Notifiable;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'id'        => 'string',
        'is_active' => 'boolean',
    ];

    protected $fillable = [
        'email',
        'password',
        'locale',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * {@inheritdoc}
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function receivesBroadcastNotificationsOn()
    {
        return 'users.' . $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

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

    /**
     * {@inheritdoc}
     */
    public function preferredLocale()
    {
        return $this->locale;
    }
}
