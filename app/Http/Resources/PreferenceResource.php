<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PreferenceResource extends JsonResource
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
        ];
    }
}