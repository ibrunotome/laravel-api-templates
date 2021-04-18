<?php

namespace App\Domain\Users\Entities;

use App\Domain\Users\Database\Factories\AuthorizedDeviceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

/**
 * App\Domain\Users\Entities\AuthorizedDevice
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Domain\Audits\Entities\Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read \App\Domain\Users\Entities\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizedDevice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizedDevice newQuery()
 * @method static Builder|AuthorizedDevice onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizedDevice query()
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizedDevice whereAuthorizationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizedDevice whereAuthorizedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizedDevice whereBrowser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizedDevice whereBrowserVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizedDevice whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizedDevice whereCountryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizedDevice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizedDevice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizedDevice whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizedDevice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizedDevice wherePlatform($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizedDevice wherePlatformVersion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizedDevice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthorizedDevice whereUserId($value)
 * @method static Builder|AuthorizedDevice withTrashed()
 * @method static Builder|AuthorizedDevice withoutTrashed()
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

    protected static function newFactory()
    {
        return AuthorizedDeviceFactory::new();
    }

    ################
    # Relationships
    ################

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
