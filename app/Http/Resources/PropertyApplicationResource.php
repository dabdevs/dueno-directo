<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyApplicationResource extends JsonResource
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
            "note" => $this->note,
            "status" => $this->status,
            "applicant" => new UserResource($this->user),
            "property" => new PropertyResource($this->property),
            "approvedAt" => $this->approved_at == null ? null : $this->approved_at->format('Y-m-d'),
            "rejectedAt" => $this->rejeced_at == null ? null : $this->rejected_at->format('Y-m-d'),
            "dateUpdated" => $this->updated_at == null ? null : $this->updated_at->format('Y-m-d'),
            "dateRegisted" => $this->created_at == null ? null : $this->created_at->format('Y-m-d'),
        ];
    }
}
