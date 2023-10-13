<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyPreferenceResource extends JsonResource
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
            'occupation' => $this->occupation,
            'minIncome' => $this->min_income,
            'maxIncome' => $this->max_income,
            'numberOfOccupants' => $this->number_of_occupants,
            'hasPets' => $this->has_pets,
            'smoker' => $this->smoker,
            'employmentStatus' => $this->employment_status,
            "property" => new PropertyResource($this->property),
            "dateRegistered" => $this->created_at == null ? null : $this->created_at->format('Y-m-d'),
            "dateUpdated" => $this->updated_at == null ? null : $this->updated_at->format('Y-m-d')
        ];
    }
}
