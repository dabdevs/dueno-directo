<?php

namespace App\Http\Requests\Api\V1\VerificationRequest;

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
            'property_id' => 'nullable|exists:properties,id',
            'user_id' => 'nullable|exists:users,id',
            'type' => 'required|string',
            'note' => 'required|string',
            'backId' => 'required|image|max:2048|mimes:jpeg,jpg,png',
            'frontId' => 'required|image|max:2048|mimes:jpeg,jpg,png'
        ];
    }
}
