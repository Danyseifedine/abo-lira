<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
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
        return [
            'sku' => ['nullable', 'string', 'max:255', Rule::unique(Product::class)->ignore($this->product->id)],
            'category_id' => 'required|exists:product_categories,id',
            'quality_id' => 'required|exists:product_qualities,id',
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique(Product::class)->ignore($this->product->id)],
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'has_variants' => 'boolean',
            'is_new' => 'boolean',
            'status' => 'boolean',
            // Only required if has_variants is false
            'price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'out_of_stock' => 'boolean',
            // Media files
            'temp_files' => 'nullable|array',
        ];
    }
}
