<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateComplexProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sku' => ['nullable', 'string', 'max:255', Rule::unique(Product::class)->ignore($this->product->id)],
            'category_id' => 'required|exists:product_categories,id',
            'quality_id' => 'required|exists:product_qualities,id',
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique(Product::class)->ignore($this->product->id)],
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'has_variants' => 'required|boolean',
            'status' => 'boolean',
            // Featured image (for size-only variants)
            'temp_files' => 'nullable|array|max:1',
            'temp_files.*.temp_path' => 'nullable|string',
            // Placement image (optional)
            'placement_image' => 'nullable|array|max:1',
            'placement_image.*.temp_path' => 'nullable|string',
            // Variants (required for complex products)
            'variants' => 'required|array|min:1',
            'variants.*.id' => 'nullable|exists:product_variants,id',
            'variants.*.color_id' => 'nullable|exists:product_variant_colors,id',
            'variants.*.size_id' => 'nullable|exists:product_variant_sizes,id',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.stock_quantity' => 'required|integer|min:0',
            'variants.*.out_of_stock' => 'boolean',
            'variants.*.status' => 'boolean',
            'variants.*.temp_files' => 'nullable|array',
            'variants.*.temp_files.*.temp_path' => 'nullable|string',
            'variants.*.existing_media' => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'variants.required' => 'At least one variant is required for complex products.',
            'variants.min' => 'At least one variant is required for complex products.',
            'variants.*.price.required' => 'Price is required for each variant.',
            'variants.*.stock_quantity.required' => 'Stock quantity is required for each variant.',
        ];
    }
}
