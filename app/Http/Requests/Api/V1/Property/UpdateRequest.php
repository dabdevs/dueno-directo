<?php

namespace App\Http\Requests\Api\V1\Property;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'title' => 'required|string|max:150',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'bedrooms' => 'required|integer|min:1',
            'bathrooms' => 'required|integer|min:1',
            'area' => 'required|integer',
            'balcony' => 'nullable|boolean',
            'patio' => 'nullable|boolean',
            'telephone' => 'nullable|string|max:20',
            'type' => ['required', 'string', 'max:255', Rule::in(['House', 'Apartment', 'Condo'])],
            'note' => 'string|max:200',
            'email' => 'nullable|string',
            'address' => 'string|max:150',
            'preferred_tenant_profile' => 'string|max:150',
            'user_id' => 'nullable|integer|exists:users,id',
            'country_id' => 'required|integer|exists:countries,id',
            'city_id' => 'required|integer|exists:cities,id',
            'state' => 'string',
            'lease_term' => 'string|max:150',
            'payment_method' => 'string',
            'security_deposit' => 'string',
            'neighborhood' => 'string',
            'get_notified_by' => ['string', 'max:150', Rule::in(['Phone', 'Email'])]
        ];
    }
}
