<?php

namespace App\Http\Requests\Api\V1\Application;

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
            'tenant_id' => 'required|exists:tenants,id',
            'property_id' => 'required|exists:properties,id',
            'note' => 'nullable|string|max:255'
        ];
    }
}