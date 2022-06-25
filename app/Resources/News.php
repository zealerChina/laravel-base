<?php

namespace App\Resources;

use App\Services\AdminUserService;
use Illuminate\Http\Resources\Json\JsonResource;

class News extends JsonResource
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
            'title' => $this->title,
            'image' => $this->image,
            'content' => mb_strlen($this->content) > 40 ? 
                            mb_substr($this->content, 0, 40) . '...' : 
                            $this->content,
            'is_top' => $this->is_top,
            'order' => $this->order,
            'updated_at' => (string)$this->updated_at,
        ];
    }
}
