<?php

namespace Preferred\Domain\Users\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Notifications\DatabaseNotification;
use Preferred\Domain\Users\Entities\AuthorizedDevice;
use Preferred\Domain\Users\Entities\LoginHistory;
use Preferred\Domain\Users\Entities\Profile;

/**
 * Class UserResource
 *
 * @package Preferred\Domain\Users\Http\Resources
 *
 * @property string                    id
 * @property string                    email
 * @property bool                      is_active
 * @property string                    email_verified_at
 * @property string                    locale
 * @property \DateTime                 created_at
 * @property \DateTime                 updated_at
 *
 * @property-read AuthorizedDevice     authorizedDevice
 * @property-read LoginHistory         loginHistories
 * @property-read Profile              profile
 * @property-read DatabaseNotification notifications
 * @property-read DatabaseNotification unreadNotifications
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                  => $this->id,
            'email'               => $this->email,
            'isActive'            => $this->is_active,
            'emailVerifiedAt'     => $this->email_verified_at,
            'locale'              => $this->locale,
            'profile'             => new ProfileResource($this->whenLoaded('profile')),
            'loginHistories'      => LoginHistoryResource::collection($this->whenLoaded('loginhistories')),
            'authorizedDevices'   => AuthorizedDeviceResource::collection($this->whenLoaded('authorizeddevices')),
            'notifications'       => NotificationResource::collection($this->whenLoaded('notifications')),
            'unreadNotifications' => NotificationResource::collection($this->whenLoaded('unreadnotifications')),
        ];
    }
}
