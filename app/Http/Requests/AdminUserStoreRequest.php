<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserStoreRequest extends FormRequest
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
            //
            'role_id' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'role_id.required' => 'Role_id is required!',
            'name.required' => 'Name is required!',
            'email.required' => 'Email is required!',
            'password.required' => 'Password is required!'
        ];
    }
}
