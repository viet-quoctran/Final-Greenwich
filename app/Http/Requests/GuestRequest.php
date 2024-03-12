<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuestRequest extends FormRequest
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
            'fullname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'numeric', 'regex:/^[0-9]{10,11}$/'],
            'message' =>['nullable']
        ];
    }
    public function messages(){
        return [
            'required' =>':attribute không được để trống',
            'email' =>':attribute không đúng định dạng email',
            'numeric' =>':attribute không đúng định dạng phone',
            'regex' =>':attribute không đúng định dạng phone',
            'unique' => ':attribute bị trùng'
        ];
    }
    
}
