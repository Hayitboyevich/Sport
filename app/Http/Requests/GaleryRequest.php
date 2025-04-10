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
            'desc_uz' => 'required',
            'desc_ru' => 'required',
            'desc_en' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'url' => 'required_if:type,3',
            'type' => 'required|in:1,2,3',
            'status' => 'required',
        ];
    }
}
