<?php

namespace App\Http\Requests\Api\V1\Preference;

use Illuminate\Foundation\Http\FormRequest;

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
            "property_id" => 'sometimes|required|numeric',
            'occupation' =>  'sometimes|required|string',
            'min_income' => 'sometimes|required|numeric',
            'max_income' => 'sometimes|required|numeric',
            'number_of_occupants' => 'sometimes|required|numeric',
            'has_pets' => 'sometimes|required|boolean',
            'smoker' => 'sometimes|required|boolean',
            'employment_status' => 'sometimes|required|string'
        ];
    }
}
