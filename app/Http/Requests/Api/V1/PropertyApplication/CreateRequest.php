<?php

namespace App\Http\Requests\Api\V1\PropertyApplication;

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
            'user_id' => 'required|integer|exists:users,id',
            'note' => 'required|string|max:255',
            'property_id' => 'required|integer|exists:properties,id'
        ];
    }
}
