<?php

namespace App\Domain\Users\Entities;

use App\Domain\Users\Database\Factories\UserFactory;
use App\Domain\Users\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Domain\Users\Entities\User
 *
 * @property string $id
 * @property string $email
 * @property string $password
 * @property bool $is_active
 * @property string|null $email_verified_at
 * @property string $locale
 * @property string $name
 * @property string|null $anti_phishing_code
 * @property string|null $email_token_confirmation
 * @property string|null $email_token_disable_account
 * @property bool $google2fa_enable
 * @property string|null $google2fa_secret
 * @property string|null $google2fa_url
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Domain\Audits\Entities\Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Domain\Users\Entities\AuthorizedDevice[] $authorizedDevices
 * @property-read int|null $authorized_devices_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Domain\Users\Entities\LoginHistory[] $loginHistories
 * @property-read int|null $login_histories_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Domain\Users\Entities\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Domain\Users\Entities\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|DatabaseNotification[] $unreadNotifications
 * @property-read int|null $unread_notifications_count
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User permission($permissions)
 * @method static Builder|User query()
 * @method static Builder|User role($roles, $guard = null)
 * @method static Builder|User whereAntiPhishingCode($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailTokenConfirmation($value)
 * @method static Builder|User whereEmailTokenDisableAccount($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereGoogle2faEnable($value)
 * @method static Builder|User whereGoogle2faSecret($value)
 * @method static Builder|User whereGoogle2faUrl($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereIsActive($value)
 * @method static Builder|User whereLocale($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements JWTSubject, AuditableContract, HasLocalePreference, MustVerifyEmail
{
    use Auditable;
    use HasRoles;
    use HasFactory;
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
        'name',
        'anti_phishing_code',
        'email_token_confirmation',
        'email_token_disable_account',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function newFactory()
    {
        return UserFactory::new();
    }

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

    public function loginHistories()
    {
        return $this->hasMany(LoginHistory::class)->orderBy('created_at', 'desc')->limit(10);
    }

    public function authorizedDevices(): HasMany
    {
        return $this->hasMany(AuthorizedDevice::class)
            ->whereNotNull('authorized_at')
            ->orderBy('created_at', 'desc');
    }

    public function unreadNotifications(): MorphMany
    {
        return $this->notifications()->whereNull('read_at');
    }

    public function notifications(): MorphMany
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
