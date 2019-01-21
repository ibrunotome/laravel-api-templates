<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AuthorizedDeviceResource
 *
 * @package App\Http\Resources
 *
 * @property string    id
 * @property string    device
 * @property string    platform
 * @property string    platform_version
 * @property string    browser
 * @property string    browser_version
 * @property string    city
 * @property string    country_name
 * @property \DateTime created_at
 */
class AuthorizedDeviceResource extends JsonResource
{
    public function toArray($request)
    {
        $milliseconds = bcdiv($this->created_at->format('u'), 1000, 0);

        return [
            'id'              => $this->id,
            'browser'         => $this->browser,
            'browserVersion'  => $this->browser_version,
            'device'          => $this->device,
            'platform'        => $this->platform,
            'platformVersion' => $this->platform_version,
            'city'            => $this->city,
            'countryName'     => $this->country_name,
            'createdAt'       => $this->created_at->format('Y-m-d\TH:i:s') . '.' . $milliseconds . 'Z'
        ];
    }
}
