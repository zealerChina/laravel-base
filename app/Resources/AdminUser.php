<?php

namespace App\Resources;

use App\Services\AdminUserService;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminUser extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'mobile' => $this->mobile,
            'status' => $this->status,
            'updated_at' => (string)$this->updated_at,
        ];
    }
}
