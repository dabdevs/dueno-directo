<?php

namespace App\Http\Requests\Api\V1\Tenant;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'user_id' => ['required', 'numeric', 'exists:users,id'],
            'occupation' => ['required', 'string', 'max:150'],
            'income' => ['required', 'numeric'],
            'desired_locations' => ['required', 'array', 'max:255', Rule::in(['Buenos Aires', 'Los Angeles', 'Santiago', 'New York', 'Chicago', 'Boston', 'Lima', 'Montevideo', 'Madrid', 'Paris'])],
            'number_of_occupants' => ['required', 'numeric'],
            'has_pets' => ['required', 'boolean'],
            'smoker' => ['required', 'boolean'],
            'employment_status'  => ['required', 'string', Rule::in(['employed', 'self-employed', 'unemployed'])],
            'additional_note' => ['required', 'string', 'max:255'],
        ];
    }
}
