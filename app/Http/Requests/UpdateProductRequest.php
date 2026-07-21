<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product');

        return [
            'brand_id' => ['required', 'integer', 'exists:brands,id'],

            'sku' => [
                'required',
                'string',
                'max:100',
                Rule::unique('products', 'sku')->ignore($productId),
            ],

            'erp_name' => ['required', 'string', 'max:255'],
            'technical_name' => ['required', 'string', 'max:255'],

            'guarantee_years' => ['nullable', 'integer', 'min:0', 'max:30'],
            'volume_liters' => ['required', 'numeric', 'min:0'],

            'base_type' => ['nullable', 'string', 'max:255'],
            'is_fibrated' => ['required', 'boolean'],
            'requires_separate_primer' => ['required', 'boolean'],

            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],

            'surface_type' => ['nullable', 'string', 'max:100'],
            'consumption_per_m2' => ['required', 'numeric', 'min:0'],
            'min_coverage_m2' => ['required', 'numeric', 'min:0'],
            'max_coverage_m2' => ['required', 'numeric', 'min:0', 'gte:min_coverage_m2'],
        ];
    }

    public function messages(): array
    {
        return [
            'brand_id.required' => 'The brand is required.',
            'brand_id.exists' => 'The selected brand does not exist.',

            'sku.required' => 'The SKU is required.',
            'sku.unique' => 'This SKU already exists.',

            'erp_name.required' => 'The ERP product name is required.',
            'technical_name.required' => 'The technical product name is required.',

            'volume_liters.required' => 'The product volume is required.',
            'price.required' => 'The product price is required.',
            'currency.size' => 'The currency must use 3 characters, for example MXN.',

            'max_coverage_m2.gte' => 'The maximum coverage must be greater than or equal to the minimum coverage.',
        ];
    }
}