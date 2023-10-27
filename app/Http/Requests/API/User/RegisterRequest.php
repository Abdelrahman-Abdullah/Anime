<?php

namespace App\Http\Requests\API\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone_number' => ['required','numeric','digits:11','unique:users,phone_number','regex:/^01[0-2|5][0-9]{8}/'],
            'password' => 'required|confirmed|string|min:8',
            'avatar' => 'nullable|image|max:2048',
            'firebase_uid' => $this->request->has('firebase_uid') ? 'required|string' : 'nullable|string',
        ];

        if ($this->request->has('firebase_uid')) {
            $rules['name'] = 'nullable|string';
            $rules['email'] = 'nullable|email|unique:users,email';
            $rules['phone_number'] = 'nullable|numeric|digits:11|unique:users,phone_number';
            $rules['password'] = 'nullable|confirmed|string|min:8';
        }

        return $rules;
    }
}
