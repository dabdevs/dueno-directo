<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class VerificationRequestResource extends JsonResource
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
            'status' => $this->status, 
            'backId' => Storage::path($this->back_id),
            'frontId' => Storage::path($this->front_id),
            'phone' => $this->phone,
            'createdAt' => $this->created_at->format('Y-m-d'),
            'updatedAt' => $this->updated_at->format('Y-m-d')
        ];
    }
}
