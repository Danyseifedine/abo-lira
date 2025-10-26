<?php

namespace App\Http\Requests\ProductCategory;

use App\Models\ProductCategory;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'parent_id' => 'nullable|exists:product_categories,id',
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:' . ProductCategory::class,
            'status' => 'boolean',
            // Category image
            'temp_files' => 'nullable|array|max:1',
            'temp_files.*.temp_path' => 'nullable|string',
        ];
    }
}
