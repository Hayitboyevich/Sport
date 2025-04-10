<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartnerRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_uz'  => 'sometimes',
            'name_ru'  => 'sometimes',
            'name_en'  => 'sometimes',
            'image' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
