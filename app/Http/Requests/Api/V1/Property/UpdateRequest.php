<?php

namespace App\Http\Requests\Api\V1\Property;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|string|required',
            'price' => 'sometimes|numeric|min:0|required',
            'bedrooms' => 'sometimes|integer|min:1',
            'bathrooms' => 'sometimes|integer|min:1',
            'area' => 'sometimes|integer|min:1',
            'location' => 'sometimes|string|max:255|required',
            'phone_number' => 'sometimes|string|max:20',
            'property_type' => 'sometimes|string|max:255',
            'property_address' => 'sometimes|string',
            'property_description' => 'sometimes|string',
            'rental_price' => 'sometimes|numeric|min:0',
            'lease_term' => 'sometimes|string|max:255',
            'availability' => 'sometimes|string|max:255',
            'rent_payment_method' => 'sometimes|string|max:255',
            'security_deposit' => 'sometimes|numeric|min:0',
            'rental_agreement' => 'nullable|string',
            'preferred_tenant_profile' => 'nullable|string',
            'additional_note' => 'nullable|string',
            'user_id' => 'sometimes|exists:users,id|required',
        ];
    }
}
