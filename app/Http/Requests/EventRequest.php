<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
           'name_uz' => 'required|string|max:255',
           'name_ru' => 'required|string|max:255',
           'name_en' => 'required|string|max:255',
           'description_uz' => 'required|string',
           'description_ru' => 'required|string',
           'description_en' => 'required|string',
           'image' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg',
        ];
    }
}
