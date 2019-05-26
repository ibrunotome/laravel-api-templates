<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class LoginHistoryResource
 *
 * @property string $device
 * @property string $platform
 * @property string $platform_version
 * @property string $browser
 * @property string $browser_version
 * @property string $ip
 * @property string $city
 * @property string $country_name
 * @property Carbon $created_at
 */
class LoginHistoryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'browser'         => $this->browser,
            'browserVersion'  => $this->browser_version,
            'device'          => $this->device,
            'platform'        => $this->platform,
            'platformVersion' => $this->platform_version,
            'city'            => $this->city,
            'countryName'     => $this->country_name,
            'ip'              => $this->ip,
            'createdAt'       => $this->created_at->format('Y-m-d\TH:i:s'),
        ];
    }
}
