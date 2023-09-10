<?php

namespace App\Http\Requests\Api\V1\Property;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'title' => 'required|string|max:255|unique:properties,title',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'bedrooms' => 'required|integer|min:1',
            'bathrooms' => 'required|integer|min:1',
            'area' => 'required|integer|min:1',
            'location' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'property_type' => 'required|string|max:255',
            'property_address' => 'required|string',
            'property_description' => 'required|string',
            'rental_price' => 'required|numeric|min:0',
            'lease_term' => 'required|string|max:255',
            'availability' => 'required|string|max:255',
            'rent_payment_method' => 'required|string|max:255',
            'security_deposit' => 'required|numeric|min:0',
            'rental_agreement' => 'nullable|string',
            'preferred_tenant_profile' => 'nullable|string',
            'additional_note' => 'nullable|string',
            'user_id' => 'sometimes|exists:users,id|required',
        ];
    }
}
