<?php

namespace App\Http\Requests\Api\V1\User;

use Illuminate\Validation\Rule;
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string'],
            'family_name' => ['required', 'string', 'max:255'],
            'given_name' => ['required', 'string', 'max:255'],
            'role'  => ['required', 'string', Rule::in(['owner', 'tenant', 'admin', 'lawyer', 'agent'])],
        ];
    }
}
