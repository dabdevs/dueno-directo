<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TenantResource extends JsonResource
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
            "occupation" => $this->occupation,
            "income" => $this->income,
            "desiredLocations" => $this->desired_locations,
            "numberOfOccupants" => $this->number_of_occupants,
            "hasPets" => $this->has_pets,
            "smoker" => $this->smoker,
            "employmentStatus" => $this->employment_status,
            "note" => $this->note,
            "dateRegistered" => $this->created_at->format('Y-m-d'),
            "dateUpdated" => $this->updated_at ? $this->updated_at->format('Y-m-d') : null,
            "user" => new UserResource($this->user),
        ];
    }
}
