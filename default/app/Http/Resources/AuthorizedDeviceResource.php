<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AuthorizedDeviceResource
 **
 *
 * @property string $id
 * @property string $device
 * @property string $platform
 * @property string $platform_version
 * @property string $browser
 * @property string $browser_version
 * @property string $city
 * @property string $country_name
 * @property Carbon $authorized_at
 * @property Carbon $created_at
 */
class AuthorizedDeviceResource extends JsonResource
{
    public function toArray($request)
    {
        if ($this->authorized_at instanceof Carbon) {
            $this->authorized_at = $this->authorized_at->format('Y-m-d\TH:i:s');
        }

        return [
            'id'              => $this->id,
            'browser'         => $this->browser,
            'browserVersion'  => $this->browser_version,
            'device'          => $this->device,
            'platform'        => $this->platform,
            'platformVersion' => $this->platform_version,
            'city'            => $this->city,
            'countryName'     => $this->country_name,
            'authorizedAt'    => $this->authorized_at,
            'createdAt'       => $this->created_at->format('Y-m-d\TH:i:s'),
        ];
    }
}
