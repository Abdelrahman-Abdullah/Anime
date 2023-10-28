<?php

namespace App\Http\Requests\API\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|string',
            'firebase_uid' => 'nullable|string',
        ];
        if ($this->request->has('firebase_uid')) {
            $rules['email'] = 'nullable|email';
            $rules['password'] = 'nullable|string';
            $rules['firebase_uid'] = ['required', 'string'];
        }
        return $rules;
    }
}
