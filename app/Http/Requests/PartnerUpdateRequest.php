<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartnerUpdateRequest extends FormRequest
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
            'image' => 'sometimes',
        ];
    }
}
