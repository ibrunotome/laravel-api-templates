<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Support\TwoFactorAuthentication;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ProfileResource
 *
 * @property string    id
 * @property string    anti_phishing_code
 * @property string    google2fa_enable
 * @property string    google2fa_secret
 * @property string    google2fa_url
 * @property string    name
 * @property string    user_id
 *
 * @property-read User user
 */
class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     * @throws \Exception
     */
    public function toArray($request)
    {
        $authenticator = new TwoFactorAuthentication($request);

        return [
            'name'             => $this->name,
            'antiAhishingCode' => $this->anti_phishing_code,
            'google2faPassed'  => $this->google2fa_enable && $authenticator->isAuthenticated(),
            'google2faEnable'  => $this->google2fa_enable,
            'google2faSecret'  => $this->when(!$this->google2fa_enable, $this->google2fa_secret),
            'google2faUrl'     => $this->when(!$this->google2fa_enable, $this->google2fa_url),
        ];
    }
}
