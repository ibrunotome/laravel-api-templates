<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Support\TwoFactorAuthenticator;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ProfileResource
 *
 * @property string    $id
 * @property string    $anti_phishing_code
 * @property string    $google2fa_enable
 * @property string    $google2fa_secret
 * @property string    $google2fa_url
 * @property string    $name
 * @property string    $user_id
 * @property Carbon    $created_at
 * @property Carbon    $updated_at
 * @property-read User $user
 */
class ProfileResource extends JsonResource
{
    /**
     * {@inheritdoc}
     */
    public function toArray($request)
    {
        $twoFactorAuthenticator = new TwoFactorAuthenticator($request);

        return [
            'id'               => $this->id,
            'name'             => $this->name,
            'antiPhishingCode' =>
                !empty($this->anti_phishing_code) ? (substr($this->anti_phishing_code, 0, 2) . '**') : null,
            'google2faPassed'  => $this->google2fa_enable && $twoFactorAuthenticator->isAuthenticated(),
            'google2faEnable'  => $this->google2fa_enable,
            'google2faSecret'  => $this->when(!$this->google2fa_enable, $this->google2fa_secret),
            'google2faUrl'     => $this->when(!$this->google2fa_enable, $this->google2fa_url),
            'createdAt'        => $this->created_at->format('Y-m-d\TH:i:s'),
            'updatedAt'        => $this->updated_at->format('Y-m-d\TH:i:s'),
        ];
    }
}
