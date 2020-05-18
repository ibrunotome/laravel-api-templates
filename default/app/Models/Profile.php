<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

/**
 * App\Models\Profile
 *
 * @property string                                                            $id
 * @property string                                                            $name
 * @property string|null                                                       $anti_phishing_code
 * @property string|null                                                       $email_token_confirmation
 * @property string|null                                                       $email_token_disable_account
 * @property bool                                                              $google2fa_enable
 * @property string|null                                                       $google2fa_secret
 * @property string|null                                                       $google2fa_url
 * @property \Illuminate\Support\Carbon|null                                   $created_at
 * @property \Illuminate\Support\Carbon|null                                   $updated_at
 * @property string                                                            $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Audit[] $audits
 * @property-read int|null                                                     $audits_count
 * @property-read \App\Models\User                                             $user
 * @method static Builder|Profile newModelQuery()
 * @method static Builder|Profile newQuery()
 * @method static Builder|Profile query()
 * @method static Builder|Profile whereAntiPhishingCode($value)
 * @method static Builder|Profile whereCreatedAt($value)
 * @method static Builder|Profile whereEmailTokenConfirmation($value)
 * @method static Builder|Profile whereEmailTokenDisableAccount($value)
 * @method static Builder|Profile whereGoogle2faEnable($value)
 * @method static Builder|Profile whereGoogle2faSecret($value)
 * @method static Builder|Profile whereGoogle2faUrl($value)
 * @method static Builder|Profile whereId($value)
 * @method static Builder|Profile whereName($value)
 * @method static Builder|Profile whereUpdatedAt($value)
 * @method static Builder|Profile whereUserId($value)
 * @mixin \Eloquent
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
