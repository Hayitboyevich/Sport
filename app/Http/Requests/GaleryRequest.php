<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GaleryRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_uz' => 'sometimes',
            'name_ru' => 'sometimes',
            'name_en' => 'sometimes',
            'desc_uz' => 'sometimes',
            'desc_ru' => 'sometimes',
            'desc_en' => 'sometimes',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'images' => 'required_if:type,2|array',
            'images.*' => 'required_if:type,2|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'url' => 'required_if:type,1',
            'type' => 'required|in:1,2',
            'status' => 'required',
        ];
    }
}
