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
            'title' => 'sometimes|required|string|max:150',
            'description' => 'sometimes|string|required|max:255',
            'price' => 'sometimes|numeric|min:0|required',
            'bedrooms' => 'sometimes|integer|min:1',
            'bathrooms' => 'sometimes|integer|min:1',
            'area' => 'sometimes|integer|min:1',
            'location' => 'sometimes|string|max:255|required',
            'phone_number' => 'sometimes|string|max:20',
            'type' => ['sometimes', 'string', 'max:255', Rule::in(['House', 'Apartment', 'Condo'])],
            'status' => ['sometimes', Rule::in(['Unlisted', 'Published', 'Booked', 'Rented'])],
            'note' => 'nullable|string',
            'user_id' => 'sometimes|exists:users,id|required',
            'tenant_id' => 'sometimes|exists:tenants,id|required',
            'agent_id' => 'nullable|exists:users,id'
        ];
    }
}
