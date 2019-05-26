<?php

namespace Preferred\Domain\Users\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Notifications\DatabaseNotification;
use Preferred\Domain\Users\Entities\AuthorizedDevice;
use Preferred\Domain\Users\Entities\LoginHistory;
use Preferred\Domain\Users\Entities\Profile;

/**
 * Class UserResource
 *
 * @property string                    $id
 * @property string                    $email
 * @property bool                      $is_active
 * @property string                    $locale
 * @property Carbon                    $email_verified_at
 * @property Carbon                    $created_at
 * @property Carbon                    $updated_at
 * @property-read AuthorizedDevice     $authorizedDevices
 * @property-read LoginHistory         $loginHistories
 * @property-read Profile              $profile
 * @property-read DatabaseNotification $notifications
 * @property-read DatabaseNotification $unreadNotifications
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
            'profile'             => new ProfileResource($this->whenLoaded('profile')),
            'loginHistories'      => LoginHistoryResource::collection($this->whenLoaded('loginhistories')),
            'authorizedDevices'   => AuthorizedDeviceResource::collection($this->whenLoaded('authorizeddevices')),
            'notifications'       => NotificationResource::collection($this->whenLoaded('notifications')),
            'unreadNotifications' => NotificationResource::collection($this->whenLoaded('unreadnotifications')),
        ];
    }
}
