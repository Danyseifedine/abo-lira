<?php

namespace App\Http\Requests\ProductColor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductColorRequest extends FormRequest
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
        $colorId = $this->route('productColor')?->id ?? $this->route('product_color');

        return [
            'name_en' => 'required|string|max:255',
            'name_ar' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:7',
                Rule::unique('product_variant_colors', 'code')->ignore($colorId),
            ],
            'status' => 'required|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name_en.required' => 'The English name is required.',
            'name_ar.required' => 'The Arabic name is required.',
            'code.required' => 'The color code is required.',
            'code.unique' => 'This color code is already in use.',
            'status.required' => 'The status is required.',
        ];
    }
}
