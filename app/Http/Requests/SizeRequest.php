<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SizeRequest extends FormRequest
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
        if ($this->isMethod('PUT')) {
            return [
                'edit_name' => 'required|string|min:3',
            ];
        } else {
            return [
                'name' => 'required|unique:sizes|string|min:3',
            ];
        }
        
    }

    public function messages()
    {
        return [
            'edit_name.required' => 'The name field is required.', 
        ];
    }
}
