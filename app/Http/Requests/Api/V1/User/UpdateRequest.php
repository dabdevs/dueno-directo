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
            'family_name' => ['nullable', 'string', 'max:150'],
            'given_name' => ['nullable', 'string', 'max:150'], 
            'password' => ['nullable', 'string'],
            'telephone' => ['nullable', 'string', 'numeric'],
            'country_id' => ['nullable', 'integer'],
            'city_id' => ['nullable', 'string'],
            'street' => ['nullable', 'string', 'max:200'],
            'number' => ['nullable', 'integer', 'numeric'],
            'appartment' =>['nullable', 'string'],
            'zip_code' => ['nullable', 'string']
        ];
    }
}
