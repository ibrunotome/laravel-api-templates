<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class CompanyResource
 *
 * @property string $id
 * @property string $name
 * @property bool   $is_active
 * @property int    $max_users
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     * @throws \Exception
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'isActive'  => $this->is_active,
            'maxUsers'  => $this->max_users,
            'createdAt' => $this->created_at->format('Y-m-d\TH:i:s'),
            'updatedAt' => $this->updated_at->format('Y-m-d\TH:i:s'),
        ];
    }
}
