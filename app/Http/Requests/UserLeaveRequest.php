<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLeaveRequest extends FormRequest
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

            'startdatetime' => 'required',
            'enddatetime' => 'required',
            'leave_reason' => 'required',
            'leave_status' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'startdatetime.required' => 'Start date time is required!',
            'enddatetime.required' => 'End date time is required!',
            'leave_reason.required' => 'Leave reason is required!',
            'leave_status.required' => 'Leave status is required!'
        ];
    }
}
