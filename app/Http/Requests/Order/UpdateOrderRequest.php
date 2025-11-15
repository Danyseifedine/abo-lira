<?php

namespace App\Http\Requests\Order;

use App\Enum\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
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
        $orderId = $this->route('order')?->id ?? $this->route('order');

        return [
            'order_number' => [
                'required',
                'string',
                'max:255',
                Rule::unique('orders', 'order_number')->ignore($orderId),
            ],
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'total_amount' => 'required|numeric|min:0',
            'status' => [
                'required',
                'string',
                Rule::in([
                    OrderStatus::PENDING->value,
                    OrderStatus::ACCEPTED->value,
                    OrderStatus::ON_THE_WAY->value,
                    OrderStatus::COMPLETED->value,
                    OrderStatus::REJECTED->value,
                    OrderStatus::REFUNDED->value,
                ]),
            ],
        ];
    }
}
