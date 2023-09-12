<?php

namespace App\Http\Requests\Api\V1\User;

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
            'family_name' => ['sometimes', 'string', 'max:150'],
            'given_name' => ['sometimes', 'string', 'max:150'], 
            'password' => ['sometimes', 'string'],
            'role'  => ['sometimes', 'string', Rule::in(['owner', 'tenant', 'admin', 'lawyer', 'agent'])],
            'telephone' => ['sometimes', 'string', 'numeric'],
            'country_id' => ['sometimes', 'integer'],
            'city' => ['sometimes', 'string'],
            'number' => ['sometimes', 'integer', 'numeric'],
            'appartment' =>['sometimes', 'string'],
            'zip_code' => ['sometimes', 'string']
        ];
    }
}
