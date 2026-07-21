<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEquivalenceMatchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'own_product_id' => [
                'required',
                'integer',
                'exists:products,id',
                'different:competitor_product_id',
            ],

            'competitor_product_id' => [
                'required',
                'integer',
                'exists:products,id',
            ],

            'match_type' => [
                'required',
                'string',
                Rule::in(['direct', 'indirect', 'monopoly_temporal', 'no_equivalent']),
            ],

            'gama' => ['required', 'string', 'max:255'],
            'technical_segmentation' => ['required', 'string', 'max:255'],
            'strategic_analysis' => ['required', 'string', 'min:20'],

            'priority' => ['required', 'integer', 'min:1', 'max:255'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'own_product_id.required' => 'The own product is required.',
            'own_product_id.exists' => 'The selected own product does not exist.',
            'own_product_id.different' => 'The own product and competitor product must be different.',

            'competitor_product_id.required' => 'The competitor product is required.',
            'competitor_product_id.exists' => 'The selected competitor product does not exist.',

            'match_type.required' => 'The match type is required.',
            'match_type.in' => 'The match type must be direct, indirect, monopoly_temporal, or no_equivalent.',

            'gama.required' => 'The product range/category is required.',
            'technical_segmentation.required' => 'The technical segmentation is required.',
            'strategic_analysis.required' => 'The strategic analysis is required.',
            'strategic_analysis.min' => 'The strategic analysis must be at least 20 characters.',

            'priority.required' => 'The priority is required.',
            'is_active.required' => 'The active status is required.',
        ];
    }
}