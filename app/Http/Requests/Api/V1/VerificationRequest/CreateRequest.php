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
            'propertyId' => 'sometimes|exists:properties,id',
            'type' => 'required|string',
            'tenantId' => 'sometimes|exists:tenants,id',
            'phone' => 'required|string',
            'backId' => 'required|image|max:2048|mimes:jpeg,jpg,png',
            'frontId' => 'required|image|max:2048|mimes:jpeg,jpg,png'
        ];
    }
}
