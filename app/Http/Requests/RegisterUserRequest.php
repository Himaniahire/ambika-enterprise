<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:users,email',
            'role_id' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'The First Name field is required.',
            'last_name.required' => 'The Last Name field is required.',
            'username.required' => 'The Username field is required.',
            'role_id.required' => 'The Role field is required.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'confirm_password.confirmed' => 'The password confirm does not match.',
            'email.required' => 'We need to know your e-mail address!',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'This email is already taken.',
        ];
    }
}
