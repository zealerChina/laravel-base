<?php

namespace App\Resources;

use App\Services\UserService;
use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'nick_name' => $this->nick_name,
            'real_name' => $this->real_name,
            'card_no' => $this->card_no,
            'mobile' => $this->mobile,
            'gender' => UserService::GENDER[$this->gender] ?? '未知',
            'consume' => $this->consume,
            'status' => $this->status,
            'invite_code' => $this->invite_code,
            'invited_by' => $this->invitedBy ? $this->invitedBy->nick_name : '',
            'status' => UserService::STATUS[$this->status] ?? '未知',
            'updated_at' => (string)$this->updated_at,
        ];
    }
}
