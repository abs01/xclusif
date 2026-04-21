<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LikeCRUDRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'post_id' => 'required|exists:posts,id',
        ];
    }

    // Mensajes personalizados de error
    public function messages()
    {
        return [
            'user_id.required' => 'The user ID is required',
            'user_id.exists' => 'The specified user does not exist',

            'post_id.required' => 'The post ID is required',
            'post_id.exists' => 'The specified post does not exist',
           
        ];
    }
}
