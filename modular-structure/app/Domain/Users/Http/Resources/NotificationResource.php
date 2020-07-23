<?php

namespace App\Domain\Users\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Notifications
 *
 * @property string $id
 * @property array  $data
 * @property Carbon $read_at
 * @property Carbon $created_at
 */
class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'data'      => $this->data,
            'readAt'    => !is_null($this->read_at)
                ? ($this->read_at->format('Y-m-d\TH:i:s'))
                : null,
            'createdAt' => $this->created_at->format('Y-m-d\TH:i:s'),
        ];
    }
}
