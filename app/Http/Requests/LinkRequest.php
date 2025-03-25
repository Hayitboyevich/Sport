<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LinkRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'name_uz' => 'required|string|max:255',
            'name_ru' => 'sometimes|string|max:255',
            'name_en' => 'sometimes|string|max:255',
            'url' => 'required|string|max:255',
            'image' => 'required|array',
        ];
    }
}
