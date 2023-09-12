<?php

namespace App\Http\Requests\Api\V1\Tenant;

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
            'occupation' => ['nullable', 'string', 'max:150'],
            'income' => ['nullable', 'numeric'],
            'desired_locations' => ['nullable', 'string', 'max:255'],
            'number_of_occupants' => ['nullable', 'numeric'],
            'has_pets' => ['nullable', 'boolean'],
            'smoker' => ['nullable', 'boolean'],
            'employment_status'  => ['nullable', 'string', Rule::in(['employed', 'self-employed', 'unemployed'])],
            'additional_note' => ['nullable', 'string', 'max:255'],
        ];
    }
}
