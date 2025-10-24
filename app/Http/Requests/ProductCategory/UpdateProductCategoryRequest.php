<?php

namespace App\Http\Requests\ProductCategory;

use App\Models\ProductCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'parent_id' => [
                'nullable',
                'exists:product_categories,id',
                Rule::notIn([$this->productCategory->id]), // Prevent setting itself as parent
            ],
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique(ProductCategory::class)->ignore($this->productCategory->id)],
            'status' => 'boolean',
        ];
    }
}
