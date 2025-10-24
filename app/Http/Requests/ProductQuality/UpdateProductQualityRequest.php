<?php

namespace App\Http\Requests\ProductQuality;

use App\Models\ProductQuality;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductQualityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique(ProductQuality::class)->ignore($this->productQuality->id)],
            'status' => 'boolean',
        ];
    }
}
