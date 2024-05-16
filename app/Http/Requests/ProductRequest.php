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
        // dd($this->isMethod('PUT'));
        if ($this->isMethod('PUT')) {
            return [
                'product_title' => 'required|string|min:3',
                'product_description' => 'required|string|min:10',
                'product_image' => '|image|mimes:jpg,jpeg,png,gif|max:2048',
                'color_ids' => 'required|array', // Ensure color_ids is an array
                'color_ids.*' => 'exists:colors,id', // Validate each color_id exists in the colors table
                'size_ids' => 'required|array', // Ensure size_ids is an array
                'size_ids.*' => 'exists:sizes,id', // Validate each size_id exists in the sizes table
            ];
        } else {
            return [
                'product_title' => 'required|string|min:3',
                'product_description' => 'required|string|min:10',
                'product_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
                'color_ids' => 'required|array', // Ensure color_ids is an array
                'color_ids.*' => 'exists:colors,id', // Validate each color_id exists in the colors table
                'size_ids' => 'required|array', // Ensure size_ids is an array
                'size_ids.*' => 'exists:sizes,id', // Validate each size_id exists in the sizes table
            ];
        }
        
    }
}
