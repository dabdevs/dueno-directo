<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\Rule;

class PropertyResource extends JsonResource
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
            'description' => $this->description,
            'price' => $this->price,
            'bedrooms' => $this->bedrooms,
            'bathrooms' => $this->bathrooms,
            'balcony' => $this->balcony,
            'area' => $this->area,
            'type' => $this->type,
            'negotiable' => $this->negotiable,
            'phoneNumber' => $this->telephone,
            'getNotifiedBy' => $this->get_notified_by,
            'note' => $this->note,
            'state' => $this->state,
            'neighborhood' => $this->neighborhood,
            'status' => $this->status,
            'country' => new CountryResource($this->country),
            'city' => new CityResource($this->city),
            'owner' => new UserResource($this->owner),
            'tenant' => new TenantResource($this->tenant),
            'agent' => new UserResource($this->agent),
            'photos' => $this->photos,
            "dateRegistered" => $this->created_at->format('Y-m-d'),
            "dateUpdated" => $this->updated_at ? $this->updated_at->format('Y-m-d') : null
        ];
    }
}
