<?php

namespace App\Http\Requests\Api\V1\Upload;

use Illuminate\Foundation\Http\FormRequest;

class PropertyPhotosRequest extends FormRequest
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
            'type' => 'required|string',
            'property_id' => 'required|numeric',
            'deleted_photos' => 'nullable|array',
            'deleted_photos.*' => 'integer|exists:photos,id',
            'photos' => 'required|array|min:1|max:5',
            'photos.*' => 'image|max:2048|mimes:jpeg,jpg,png', 
        ];
    }
}
