<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
                'product_title' => 'required|string|min:3',
                'product_description' => 'required|string|min:10',
                'product_image' => '|image|mimes:jpg,jpeg,png,gif|max:2048',
                'color_ids' => 'required|array',
                'color_ids.*' => 'exists:colors,id',
                'size_ids' => 'required|array',
                'size_ids.*' => 'exists:sizes,id',
            ];
        } else {
            return [
                'product_title' => 'required|string|min:3',
                'product_description' => 'required|string|min:10',
                'product_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
                'color_ids' => 'required|array', 
                'color_ids.*' => 'exists:colors,id',
                'size_ids' => 'required|array',
                'size_ids.*' => 'exists:sizes,id',
            ];
        }
        
    }
}
