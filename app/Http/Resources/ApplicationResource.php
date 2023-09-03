<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
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
            "id" => $this->id,
            "property" => $this->property_id,
            "tenant" => new TenantResource($this->tenant),
            "createdAt" => $this->updated_at->format('Y-m-d'),
            "updatedAt" => $this->created_at->format('Y-m-d')
        ];
    }
}
