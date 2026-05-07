<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCRUDRequest extends FormRequest
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

        // Get the user ID from the route for unique ignore on updates
        $userId = $this->route('user')?->id;
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'name' => $isUpdate ? 'sometimes|string|max:255' : 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'dni' =>  $isUpdate ? 'sometimes|nullable|min:5|max:9' . $userId : 'required|min:5|max:9|unique:users,dni,' . $userId,
            'email' => $isUpdate ? 'sometimes|nullable|email|min:5|max:255' . $userId : 'required|email|min:5|max:255|unique:users,email,' . $userId,
            'phone' => 'nullable|string|max:20',
            'password' => $isUpdate
                ? 'sometimes|nullable|string|min:8|confirmed'
                : 'required|string|min:8|confirmed',
            'tier_id' => $isUpdate ? 'sometimes|exists:roles,id' : 'required|exists:roles,id',
            'role_id' => $isUpdate ? 'sometimes|exists:roles,id' : 'required|exists:roles,id',

        ];
    }

    // Mensajes personalizados de error
    public function messages()
    {
        return [
            'name.required' => 'The name is required',
            'name.string' => 'The name must be a string',
            'name.max' => 'The name must not exceed 255 characters',

            'lastname.required' => 'The lastname is required',
            'lastname.string' => 'The lastname must be a string',
            'lastname.max' => 'The lastname must not exceed 255 characters',

            'dni.required' => 'The DNI is required',
            'dni.string' => 'The DNI must be a string',
            'dni.unique' => 'This DNI is already registered',

            'email.required' => 'The email is required',
            'email.email' => 'The email must be valid',
            'email.unique' => 'This email is already registered',

            'phone.string' => 'The phone must be a string',
            'phone.max' => 'The phone must not exceed 20 characters',

            'password.required' => 'The password is required',
            'password.min' => 'The password must be at least 8 characters',

            'tier_id.required' => 'The tier is required',
            'tier_id.exists' => 'The selected tier does not exist',

            'role_id.required' => 'The role is required',
            'role_id.exists' => 'The selected role does not exist',
        
        ];
    }
}