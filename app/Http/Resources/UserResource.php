<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return [
            "email" => $this->email,
            "dateRegistered" => $this->created_at->format('Y-m-d'),
            "givenName" => $this->given_name,
            "familyName" => $this->family_name,
            "emailVerifiedAt" => $this-> email_verified_at->format('Y-m-d'),
            "type" => $this->owner,
            "occupation" => $this->ocupation,
            "income" => $this->income,
            "desiredLocation" => $this->desired_location,
            "numberOfOccupants" => $this->number_of_occupants,
            "hasPets" => $this->has_pets,
            "smoker" => $this->smoker,
            "employmentStatus" => $this->employment_status,
            "additionalNote" => $this->additional_note,
            "dateUpdated" => $this-> updated_at->format('Y-m-d')
        ];
    }
}
