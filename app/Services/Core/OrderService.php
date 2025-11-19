<?php

namespace App\Services\Core;

use App\Enum\OrderStatus;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;

class OrderService
{
    /**
     * Get base query for orders
     * This query will be used by the HasDataTable trait
     *
     * @uses HasDataTable trait
     */
    public function getBaseQuery(): Builder
    {
        return Order::with(['items'])
            ->select('id', 'order_number', 'f_name', 'l_name', 'phone_number', 'address', 'city', 'total_amount', 'status', 'created_at');
    }

    /**
     * Get DataTable configuration
     */
    public function getDataTableConfig(): array
    {
        return [
            'searchColumns' => ['order_number', 'f_name', 'l_name', 'phone_number', 'city', 'address'],
            'allowedSorts' => ['order_number', 'f_name', 'l_name', 'total_amount', 'status', 'created_at'],
            'allowedFilters' => [
                'status' => function ($query, $value) {
                    $query->where('status', $value);
                },
                'created_from' => function ($query, $value) {
                    $query->whereDate('created_at', '>=', $value);
                },
                'created_to' => function ($query, $value) {
                    $query->whereDate('created_at', '<=', $value);
                },
                'min_amount' => function ($query, $value) {
                    $query->where('total_amount', '>=', $value);
                },
                'max_amount' => function ($query, $value) {
                    $query->where('total_amount', '<=', $value);
                },
            ],
        ];
    }

    /**
     * Find order by ID
     */
    public function findById(int $id): ?Order
    {
        return Order::find($id);
    }

    /**
     * Find order by ID or fail
     */
    public function findByIdOrFail(int $id): Order
    {
        return Order::with(['items.product', 'items.variant'])->findOrFail($id);
    }

    /**
     * Update order data
     */
    public function update(Order $order, array $data): bool
    {
        return $order->update($data);
    }

    /**
     * Create a new order
     */
    public function create(array $data): Order
    {
        return Order::create($data);
    }

    /**
     * Delete an order
     */
    public function delete(Order $order): bool
    {
        return $order->delete();
    }

    /**
     * Change order status
     */
    public function changeStatus(Order $order, OrderStatus|string $status): void
    {
        // Convert OrderStatus enum to string if needed
        $statusValue = $status instanceof OrderStatus ? $status->value : (string) $status;

        // Trim whitespace
        $statusValue = trim($statusValue);

        $order->changeStatus($statusValue);
    }

    /**
     * Get orders by status
     */
    public function getOrdersByStatus(OrderStatus|string $status): Builder
    {
        $statusValue = $status instanceof OrderStatus ? $status->value : $status;

        return Order::where('status', $statusValue);
    }
}
