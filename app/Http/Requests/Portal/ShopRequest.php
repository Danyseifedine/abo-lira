<?php

namespace App\Http\Requests\Portal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category' => ['nullable', 'integer', 'exists:product_categories,id'],
            'price_min' => ['nullable', 'numeric', 'min:0'],
            'price_max' => ['nullable', 'numeric', 'min:0', 'gte:price_min'],
            'sort' => ['nullable', 'string', Rule::in(['latest', 'popularity', 'newness', 'rating', 'price_low', 'price_high'])],
            'page' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
