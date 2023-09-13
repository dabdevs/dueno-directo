<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'family_name' => ['required', 'string', 'max:255'],
            'given_name' => ['required', 'string', 'max:255'],
            'role'  => ['required', 'string', Rule::in(['owner', 'tenant'])],
            'occupation' => ['required', 'string', 'max:150'],
            'income' => ['required', 'numeric'],
            'desired_locations' => ['required', 'string', 'max:255'],
            'number_of_occupants' => ['required', 'numeric'],
            'has_pets' => ['required', 'boolean'],
            'smoker' => ['required', 'boolean'],
            'employment_status'  => ['required', 'string', Rule::in(['Employed', 'Self-Employed', 'Unemployed'])],
            'note' => ['required', 'string', 'max:255'],
        ];
    }
}
