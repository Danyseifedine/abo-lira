<?php

namespace App\Http\Requests\ProductQuality;

use App\Models\ProductQuality;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductQualityRequest extends FormRequest
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
            'slug' => 'nullable|string|max:255|unique:' . ProductQuality::class,
            'status' => 'boolean',
        ];
    }
}
