<?php

namespace App\Http\Requests\Discount;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDiscountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $hasLimitedTime = $this->input('has_limited_time_discount', true);

        return [
            'discount_price' => 'required|numeric|min:0',
            'has_limited_time_discount' => 'boolean',
            'discount_start_date' => $hasLimitedTime ? 'required|date' : 'nullable|date',
            'discount_end_date' => $hasLimitedTime ? 'required|date|after_or_equal:discount_start_date' : 'nullable|date',
        ];
    }

    public function messages(): array
    {
        return [
            'discount_price.required' => 'Discount price is required.',
            'discount_price.numeric' => 'Discount price must be a number.',
            'discount_price.min' => 'Discount price must be at least 0.',
            'discount_start_date.required' => 'Discount start date is required when limited time discount is enabled.',
            'discount_end_date.required' => 'Discount end date is required when limited time discount is enabled.',
            'discount_end_date.after_or_equal' => 'Discount end date must be after or equal to start date.',
        ];
    }
}

