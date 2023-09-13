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
            'area' => $this->area,
            'location' => $this->location,
            'phoneNumber' => $this->phone_number,
            'propertyType' => $this->property_type,
            'propertyAddress' => $this->property_address,
            'leaseTerm' => $this->lease_term,
            'negotiable' => $this->negotiable,
            'rentPaymentMethod' => $this->rent_payment_method,
            'securityDeposit' => $this->security_deposit,
            'rentalAgreement' => $this->rental_agreement,
            'preferredTenantProfile' => $this->preferred_tenant_profile,
            'additionalNote' => $this->additional_note,
            'owner' => new UserResource($this->owner), 
            'tenant' => new TenantResource($this->tenant),
            'agent' => new UserResource($this->agent), 
            'status' => $this->status,
            "dateRegistered" => $this->created_at->format('Y-m-d'),
            "dateUpdated" => $this->updated_at ? $this->updated_at->format('Y-m-d') : null
        ];
    }
}
