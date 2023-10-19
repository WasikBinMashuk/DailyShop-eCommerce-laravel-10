<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerFormRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        return [
            'name' => 'required|string|min:1|max:20',
            'email' => 'required|email|min:1|max:100|unique:customers',
            'password' => 'required|string|confirmed|min:6',
            'mobile' => 'required|numeric|size:11',
        ];
    }
}
