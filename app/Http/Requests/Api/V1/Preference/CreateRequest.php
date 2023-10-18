<?php

namespace App\Http\Requests\Api\V1\Preference;

use Illuminate\Foundation\Http\FormRequest;
use \Illuminate\Validation\Rule;

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
            'type' => 'required|in:property,user',
            'user_id' => [
                'exists:users,id',
                Rule::requiredIf(function () {
                    return $this->input('type') === 'user';
                }),
            ],
            'property_id' => [
                'exists:properties,id',
                Rule::requiredIf(function () {
                    return $this->input('type') === 'property';
                }),
            ],
            'occupation' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($this->input('type') == 'property' && is_string($value)) {
                        $fail('The occupations must be an array of strings.');
                    }
                    if ($this->input('type') == 'user' && !is_string($value)) {
                        $fail('The occupations must be a string.');
                    }
                },
            ],
            'min_income' => [
                'required',
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) {
                    if ($this->input('max_income') < $value) {
                        $fail('The minimum income must be lower than the maximum income.');
                    }
                },
            ],
            'max_income' => [
                'required',
                'numeric',
                'min:1',
                function ($attribute, $value, $fail) {
                    if ($this->input('min_income') > $value) {
                        $fail('The maximum income must be greater than the minimum income.');
                    }
                },
            ],
            'number_of_occupants' => 'required|numeric|min:1',
            'has_pets' => 'required|boolean',
            'smoker' => 'required|boolean',
            'employment_status' => 'required|' . Rule::in(['Employed', 'Unemployed', 'Self-Employed']),
        ];
    }
}
