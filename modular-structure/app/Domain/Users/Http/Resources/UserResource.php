<?php

namespace App\Domain\Users\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 *
 * @mixin \App\Domain\Users\Entities\User
 */
class UserResource extends JsonResource
{
    /**
     * {@inheritdoc}
     */
    public function toArray($request)
    {
        if ($this->email_verified_at instanceof Carbon) {
            $this->email_verified_at = $this->email_verified_at->format('Y-m-d\TH:i:s');
        }

        return [
            'id'                  => $this->id,
            'email'               => $this->email,
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
