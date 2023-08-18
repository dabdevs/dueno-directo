<?php

namespace App\Http\Requests\Api\V1\Listing;

use Illuminate\Foundation\Http\FormRequest;

class CreateListingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone_number' => 'required|string',
            'address' => 'required|string',
            'property_address' => 'required|string',
            'property_type' => 'required|string|in:apartment,house,condo',
            'property_description' => 'nullable|string',
            'rental_price' => 'required|numeric',
            'lease_term' => 'required|numeric',
            'availability' => 'nullable|date',
            'rent_payment_method' => 'required|string|in:cash,card,transfer',
            'security_deposit' => 'required|numeric',
            'rental_agreement' => 'nullable|string',
            'preferred_tenant_profile' => 'nullable|string',
            'additional_note' => 'nullable|string',
            'user_id' => 'required|numeric|exists:users,id'
        ];
    }
}
