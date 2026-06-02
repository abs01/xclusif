<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SponsorRequest extends FormRequest
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
            'company_name' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
            'file_path' => 'nullable|image|max:5120',

            'publicity_url' => 'nullable|url',
            'is_active' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'company_name.required' => 'El nombre de la empresa es requerido',
            'company_name.max' => 'El nombre de la empresa no debe exceder 255 caracteres',
            'content.required' => 'El contenido es requerido',
            'content.max' => 'El contenido no debe exceder 1000 caracteres',
            'publicity_url.url' => 'La URL debe ser válida',
            'is_active.required' => 'El estado es requerido',
            'is_active.boolean' => 'El estado debe ser verdadero o falso',
        ];
    }
}
