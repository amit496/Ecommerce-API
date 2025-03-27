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
        return true; // Change as needed for authorization checks
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sku' => 'unique:products,sku', // Fixed the incomplete rule
            'name' => 'required|string|max:350',
            'description' => 'nullable|string|min:50|max:3000',
            'price' => 'required|numeric|gt:0',
            'stock_quantity' => 'required|integer|gt:0',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ];
    }

    /**
     * Get the custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'sku.unique' => 'The SKU must be unique.',
            'name.required' => 'The product name is required.',
            'name.string' => 'The product name must be a valid string.',
            'name.max' => 'The product name cannot exceed 255 characters.',
            'description.min' => 'The product description must be at least 50 characters.',
            'description.max' => 'The product description cannot exceed 1000 characters.',
            'price.required' => 'The product price is required.',
            'price.numeric' => 'The price must be a valid number.',
            'price.gt' => 'The price must be greater than 0.',
            'stock_quantity.required' => 'The stock quantity is required.',
            'stock_quantity.integer' => 'The stock quantity must be a valid integer.',
            'stock_quantity.gt' => 'The stock quantity must be greater than 0.',
            'images.required' => 'At least one image is required.',
            'images.array' => 'The images field must be an array.',
            'images.*.image' => 'Each uploaded file must be a valid image.',
            'images.*.mimes' => 'The images must be of type jpeg, png, jpg, gif, or svg.',
            'images.*.max' => 'Each image cannot exceed 2MB in size.',
        ];
    }
}
