<?php

namespace App\Http\Requests\Api\V1\VerificationRequest;

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
            'phone' => 'sometimes|string',
            'backId' => 'sometimes|image|max:2048|mimes:jpeg,jpg,png',
            'frontId' => 'sometimes|image|max:2048|mimes:jpeg,jpg,png',
            'userId' => 'required|exists:users,id',
            'status' => ['sometimes', 'string', Rule::in(['pending', 'approved', 'rejected'])]
        ];
    }
}
