<?php

namespace App\Http\Requests\Api\V1\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'given_name' => 'nullable|string|max:150',
            'family_name' => 'nullable|string|max:150',
            'ocupation' => 'nullable|string|max:150',
            'income' => 'nullable|numeric',
            'desired_location' => 'nullable|string|max:150',
            'number_of_occupants' => 'nullable|numeric',
            'number_of_occupants' => 'nullable|numeric',
            'has_pets' => 'nullable|boolean',
            'smoker' => 'nullable|boolean',
            'employment_status' => 'nullable|string|in:employed,self-employed,unemployed,student',
            'additional_note' => 'nullable|string|max:255',
        ];
    }
}
