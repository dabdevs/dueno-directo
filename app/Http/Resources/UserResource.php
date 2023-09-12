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
            "id" => $this->id,
            "email" => $this->email,
            "givenName" => $this->given_name,
            "familyName" => $this->family_name,
            "avatar" => $this->avatar,
            "role" => $this->role,
            'telephone' => $this->telephone,
            'country' => new CountryResource($this->country),
            'city' => $this->city,
            'number' => $this->number,
            'appartment' => $this->appartment,
            'zipCode' => $this->zip_code,
            "emailVerifiedAt" => $this->email_verified_at ? $this->email_verified_at->format('Y-m-d') : null,
            "dateRegistered" => $this->created_at->format('Y-m-d'),
            "dateUpdated" => $this->updated_at ? $this->updated_at->format('Y-m-d') : null
        ];
    }
}
