<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

/**
 * App\Models\AuthorizedDevice
 *
 * @property string $id
 * @property string $device
 * @property string $platform
 * @property string|null $platform_version
 * @property string $browser
 * @property string|null $browser_version
 * @property string|null $city
 * @property string|null $country_name
 * @property string $authorization_token
 * @property string|null $authorized_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\AuthorizedDeviceFactory factory(...$parameters)
 * @method static Builder|AuthorizedDevice newModelQuery()
 * @method static Builder|AuthorizedDevice newQuery()
 * @method static \Illuminate\Database\Query\Builder|AuthorizedDevice onlyTrashed()
 * @method static Builder|AuthorizedDevice query()
 * @method static Builder|AuthorizedDevice whereAuthorizationToken($value)
 * @method static Builder|AuthorizedDevice whereAuthorizedAt($value)
 * @method static Builder|AuthorizedDevice whereBrowser($value)
 * @method static Builder|AuthorizedDevice whereBrowserVersion($value)
 * @method static Builder|AuthorizedDevice whereCity($value)
 * @method static Builder|AuthorizedDevice whereCountryName($value)
 * @method static Builder|AuthorizedDevice whereCreatedAt($value)
 * @method static Builder|AuthorizedDevice whereDeletedAt($value)
 * @method static Builder|AuthorizedDevice whereDevice($value)
 * @method static Builder|AuthorizedDevice whereId($value)
 * @method static Builder|AuthorizedDevice wherePlatform($value)
 * @method static Builder|AuthorizedDevice wherePlatformVersion($value)
 * @method static Builder|AuthorizedDevice whereUpdatedAt($value)
 * @method static Builder|AuthorizedDevice whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|AuthorizedDevice withTrashed()
 * @method static \Illuminate\Database\Query\Builder|AuthorizedDevice withoutTrashed()
 * @mixin \Eloquent
 */
class AuthorizedDevice extends Model implements AuditableContract
{
    use Auditable;
    use HasFactory;
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
