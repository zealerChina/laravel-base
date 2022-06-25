<?php

namespace App\Resources;

use App\Services\AdminUserService;
use App\Services\SmsService;
use Illuminate\Http\Resources\Json\JsonResource;

class Sms extends JsonResource
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
            'mobile' => $this->mobile,
            'code' => $this->code,
            'type' => SmsService::TYPE[$this->type] ?? '未知',
            'status' => SmsService::STATUS[$this->status] ?? '未知',
            'content' => $this->content,
            'updated_at' => (string)$this->updated_at,
        ];
    }
}
