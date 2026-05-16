<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the user ID from the route, handling both model binding and raw string.
     */
    private function getRouteUserId(): ?int
    {
        $user = $this->route('user');

        if ($user instanceof User) {
            return $user->id;
        }

        if (is_numeric($user)) {
            return (int) $user;
        }

        return null;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $userId   = $this->getRouteUserId();
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'name'      => $isUpdate ? 'sometimes|string|max:255'     : 'required|string|max:255',
            'lastname'  => $isUpdate ? 'sometimes|string|max:255'     : 'required|string|max:255',
            'dni'       => $isUpdate
                            ? 'sometimes|nullable|min:5|max:9' . $userId
                            : 'required|min:5|max:9|unique:users,dni',
            'email'     => $isUpdate
                            ? 'sometimes|nullable|email|max:255' . $userId
                            : 'required|email|max:255|unique:users,email',
            'phone'     => 'nullable|string|max:20',
            'password'  => $isUpdate
                            ? 'sometimes|nullable|string|min:8|confirmed'
                            : 'required|string|min:8|confirmed',

            // These are backoffice-only fields; API users shouldn't set them freely.
            // Remove these two lines if regular users should never change role/tier:
            'tier_id'   => $isUpdate ? 'sometimes|exists:tiers,id'   : 'nullable|exists:tiers,id',
            'role_id'   => $isUpdate ? 'sometimes|exists:roles,id'   : 'nullable|exists:roles,id',
        ];
    }

    /**
     * Override failedValidation to always return JSON (not a redirect).
     * This is the key difference from the backoffice request.
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'name.required'      => 'The name is required',
            'name.string'        => 'The name must be a string',
            'name.max'           => 'The name must not exceed 255 characters',

            'lastname.required'  => 'The lastname is required',
            'lastname.string'    => 'The lastname must be a string',
            'lastname.max'       => 'The lastname must not exceed 255 characters',

            'dni.required'       => 'The DNI is required',
            'dni.min'            => 'The DNI must be at least 5 characters',
            'dni.max'            => 'The DNI must not exceed 9 characters',
            'dni.unique'         => 'This DNI is already registered',

            'email.required'     => 'The email is required',
            'email.email'        => 'The email must be a valid address',
            'email.unique'       => 'This email is already registered',

            'phone.string'       => 'The phone must be a string',
            'phone.max'          => 'The phone must not exceed 20 characters',

            'password.required'  => 'The password is required',
            'password.min'       => 'The password must be at least 8 characters',
            'password.confirmed' => 'The passwords do not match',

            'tier_id.exists'     => 'The selected tier does not exist',
            'role_id.exists'     => 'The selected role does not exist',
        ];
    }
}