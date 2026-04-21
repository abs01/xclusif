<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PostCRUDRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'content' => 'required|string',
        ];

        
    }

        // Mensajes personalizados de error
    public function messages() { 
        return [
            'title.required' => 'The title is required',
            'title.string' => 'The title must be a string',
            'title.max' => 'The title must not exceed 255 characters',
            'user_id.required' => 'The user is required',
            'user_id.exists' => 'The selected user does not exist',
            'content.required' => 'The content is required',
            'content.string' => 'The content must be a string',
        ]; 
    }
}
