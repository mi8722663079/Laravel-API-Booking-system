<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EditEventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "title" => "required|string|max:255",
            "description" => "nullable|string",
            "start_date" => "required|date",
            "avaliable_seats" => "required|integer|min:0",
            "location" => "nullable|string|max:255",
            "category_id" => "required|exists:categories,id",
            "images" => "nullable|array",
            "images.*" => "image|mimes:jpg,jpeg,png"
        ];
    }
}
