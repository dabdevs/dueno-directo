<?php

namespace App\Http\Requests\Api\V1\Preference;

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
            "property_id" => 'required|numeric',
            'occupation' =>  'required|string',
            'min_income' => 'required|numeric',
            'max_income' => 'required|numeric',
            'number_of_occupants' => 'required|numeric',
            'has_pets' => 'required|boolean',
            'smoker' => 'required|boolean',
            'employment_status' => 'required|string',
        ];
    }
}
