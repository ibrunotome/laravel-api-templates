<?php

namespace App\Http\Resources;

use App\Support\TwoFactorAuthenticator;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 *
 * @mixin \App\Models\User
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        if ($this->email_verified_at instanceof Carbon) {
            $this->email_verified_at = $this->email_verified_at->format('Y-m-d\TH:i:s');
        }

        $twoFactorAuthenticator = new TwoFactorAuthenticator($request);

        return [
            'id'                  => $this->id,
            'email'               => $this->email,
            'name'                => $this->name,
            'antiPhishingCode'    =>
                !empty($this->anti_phishing_code) ? substr($this->anti_phishing_code, 0, 2) . '**' : null,
            'google2faPassed'     => $this->google2fa_enable && $twoFactorAuthenticator->isAuthenticated(),
            'google2faEnable'     => $this->google2fa_enable,
            'google2faSecret'     => $this->when(!$this->google2fa_enable, $this->google2fa_secret),
            'google2faUrl'        => $this->when(!$this->google2fa_enable, $this->google2fa_url),
            'isActive'            => $this->is_active,
            'emailVerifiedAt'     => $this->email_verified_at,
            'locale'              => $this->locale,
            'createdAt'           => $this->created_at->format('Y-m-d\TH:i:s'),
            'updatedAt'           => $this->updated_at->format('Y-m-d\TH:i:s'),
            'loginHistories'      => LoginHistoryResource::collection($this->whenLoaded('loginhistories')),
            'authorizedDevices'   => AuthorizedDeviceResource::collection($this->whenLoaded('authorizeddevices')),
            'notifications'       => NotificationResource::collection($this->whenLoaded('notifications')),
            'unreadNotifications' => NotificationResource::collection($this->whenLoaded('unreadnotifications')),
        ];
    }
}
