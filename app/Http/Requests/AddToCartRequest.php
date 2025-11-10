<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
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
        return [
            'slug' => ['required', 'string', 'exists:products,slug'],
            'variant_id' => ['required', 'integer', 'exists:product_variants,id'],
            'color_id' => ['nullable', 'required_without:size_id', 'exists:product_variant_colors,id'],
            'size_id' => ['nullable', 'required_without:color_id', 'exists:product_variant_sizes,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'slug.required' => __('validation.required', ['attribute' => __('detail.product')]),
            'slug.exists' => __('validation.exists', ['attribute' => __('detail.product')]),
            'variant_id.required' => __('validation.required', ['attribute' => __('detail.variant')]),
            'variant_id.exists' => __('validation.exists', ['attribute' => __('detail.variant')]),
            'color_id.required_without' => __('validation.required_without', ['attribute' => __('detail.color'), 'values' => __('detail.size')]),
            'color_id.exists' => __('validation.exists', ['attribute' => __('detail.color')]),
            'size_id.required_without' => __('validation.required_without', ['attribute' => __('detail.size'), 'values' => __('detail.color')]),
            'size_id.exists' => __('validation.exists', ['attribute' => __('detail.size')]),
            'quantity.required' => __('validation.required', ['attribute' => __('detail.quantity')]),
            'quantity.integer' => __('validation.integer', ['attribute' => __('detail.quantity')]),
            'quantity.min' => __('validation.min.numeric', ['attribute' => __('detail.quantity'), 'min' => 1]),
        ];
    }
}
