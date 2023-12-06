<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
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
            'department_id' => 'required',
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'mobile_no' => 'required',
            'address' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'department_id.required' => 'Department_id is required!',
            'name.required' => 'Name is required!',
            'email.required' => 'Email is required!',
            'password.required' => 'Password is required!',
            'mobile_no.required' => 'Mobile number is required!',
            'address.required' => 'Address is required!'
        ];
    }
}
