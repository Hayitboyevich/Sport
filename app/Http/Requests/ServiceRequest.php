<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_uz' => 'required',
            'name_ru' => 'sometimes',
            'name_en' => 'sometimes',
            'value' => 'sometimes',
            'image' => 'sometimes',
            'status' => 'sometimes',
            'type' => 'required|in:1,2,3',
        ];
    }
}
