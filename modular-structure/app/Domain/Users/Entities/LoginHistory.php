<?php

namespace App\Domain\Users\Entities;

use App\Domain\Users\Database\Factories\LoginHistoryFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Domain\Users\Entities\LoginHistory
 *
 * @property string $id
 * @property string|null $device
 * @property string|null $platform
 * @property string|null $platform_version
 * @property string|null $browser
 * @property string|null $browser_version
 * @property string|null $ip
 * @property string|null $city
 * @property string|null $region_code
 * @property string|null $region_name
 * @property string|null $country_code
 * @property string|null $country_name
 * @property string|null $continent_code
 * @property string|null $continent_name
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $zipcode
 * @property \Illuminate\Support\Carbon $created_at
 * @property string $user_id
 * @property-read \App\Domain\Users\Entities\User $user
 * @method static Builder|LoginHistory newModelQuery()
 * @method static Builder|LoginHistory newQuery()
 * @method static Builder|LoginHistory query()
 * @method static Builder|LoginHistory whereBrowser($value)
 * @method static Builder|LoginHistory whereBrowserVersion($value)
 * @method static Builder|LoginHistory whereCity($value)
 * @method static Builder|LoginHistory whereContinentCode($value)
 * @method static Builder|LoginHistory whereContinentName($value)
 * @method static Builder|LoginHistory whereCountryCode($value)
 * @method static Builder|LoginHistory whereCountryName($value)
 * @method static Builder|LoginHistory whereCreatedAt($value)
 * @method static Builder|LoginHistory whereDevice($value)
 * @method static Builder|LoginHistory whereId($value)
 * @method static Builder|LoginHistory whereIp($value)
 * @method static Builder|LoginHistory whereLatitude($value)
 * @method static Builder|LoginHistory whereLongitude($value)
 * @method static Builder|LoginHistory wherePlatform($value)
 * @method static Builder|LoginHistory wherePlatformVersion($value)
 * @method static Builder|LoginHistory whereRegionCode($value)
 * @method static Builder|LoginHistory whereRegionName($value)
 * @method static Builder|LoginHistory whereUserId($value)
 * @method static Builder|LoginHistory whereZipcode($value)
 * @mixin \Eloquent
 */
class LoginHistory extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected static $unguarded = true;

    public $incrementing = false;

    protected $keyType = 'string';

    protected static function newFactory()
    {
        return LoginHistoryFactory::new();
    }

    ################
    # Relationships
    ################

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
