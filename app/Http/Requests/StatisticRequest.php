<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StatisticRequest extends FormRequest
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
            'value' => 'required',
            'status' => 'required|boolean',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
       'status' => filter_var($this->status, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE),
        ]);
    }
}
