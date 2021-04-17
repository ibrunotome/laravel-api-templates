<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class LoginHistoryResource
 *
 * @mixin \App\Models\LoginHistory
 */
class LoginHistoryResource extends JsonResource
{
    public function toArray($request): array
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
