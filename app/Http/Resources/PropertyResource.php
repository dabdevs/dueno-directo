<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'propertyDescription' => $this->property_description,
            'rentalPrice' => $this->rental_price,
            'leaseTerm' => $this->lease_term,
            'availability' => $this->availability,
            'rentPaymentMethod' => $this->rent_payment_method,
            'securityDeposit' => $this->security_deposit,
            'rentalAgreement' => $this->rental_agreement,
            'preferredTenantProfile' => $this->preferred_tenant_profile,
            'additionalNote' => $this->additional_note,
            'owner' => $this->owner, 
            'tenant' => new TenantResource($this->tenant),
            'active' => $this->active,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
