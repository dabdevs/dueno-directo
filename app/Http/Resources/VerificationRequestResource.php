<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'phone' => $this->phone,
            'documents' => DocumentResource::collection($this->documents),
            "dateRegistered" => $this->created_at->format('Y-m-d'),
            "dateUpdated" => $this->updated_at ? $this->updated_at->format('Y-m-d') : null
        ];
    }
}
