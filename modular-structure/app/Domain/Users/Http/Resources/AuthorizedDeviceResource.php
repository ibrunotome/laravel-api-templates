<?php

namespace App\Domain\Users\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AuthorizedDeviceResource
 *
 * @mixin \App\Domain\Users\Entities\AuthorizedDevice
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
