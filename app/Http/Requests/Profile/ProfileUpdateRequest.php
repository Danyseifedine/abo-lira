<?php

namespace App\Http\Requests\Profile;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'avatar' => ['nullable', function ($attribute, $value, $fail) {
                if ($value === 'remove') {
                    return; // Allow 'remove' string
                }
                if ($value && !$value instanceof \Illuminate\Http\UploadedFile) {
                    $fail('The avatar must be an image file.');
                    return;
                }
                if ($value && $value->getSize() > 2048 * 1024) {
                    $fail('The avatar must not be greater than 2MB.');
                    return;
                }
                if ($value && !in_array($value->getMimeType(), ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
                    $fail('The avatar must be an image (jpeg, png, gif, webp).');
                }
            }],
        ];
    }
}
