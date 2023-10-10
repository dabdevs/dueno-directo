<?php

namespace App\Http\Requests\Api\V1\Upload;

use Illuminate\Foundation\Http\FormRequest;

class PropertyDeletePhotosRequest extends FormRequest
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
            'deleted_photos' => 'required|array',
            'deleted_photos.*' => 'integer|exists:photos,id',
        ];
    }
}
