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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sku' => 'required|string|max:255|unique:products',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'sku.required' => 'The SKU is required.',
            'sku.unique' => 'The SKU must be unique.',
            'name.required' => 'The product name is required.',
            'price.required' => 'The product price is required.',
            'images.required' => 'At least one image is required.',
            'images.*.image' => 'Each uploaded file must be an image.',
        ];
    }
}
