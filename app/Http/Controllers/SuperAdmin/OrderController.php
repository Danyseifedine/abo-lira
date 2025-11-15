<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Enum\OrderStatus;
use App\Http\Controllers\BaseController;
use App\Models\Order;
use App\Navigation\SuperAdminPath;
use App\Services\Core\OrderService;
use Inertia\Inertia;

class OrderController extends BaseController
{
    public function __construct(
        private OrderService $orderService
    ) {}

    public function index()
    {
        $query = $this->orderService->getBaseQuery();
        $config = $this->orderService->getDataTableConfig();

        $orders = $this->dataTable(
            $query,
            $config['searchColumns'],
            $config['allowedSorts'],
            $config['allowedFilters']
        );

        return Inertia::render(SuperAdminPath::view('orders/Index'), [
            'orders' => $orders,
            'filters' => $this->getFilters(['status', 'created_from', 'created_to', 'min_amount', 'max_amount']),
            'columnLabels' => __('datatable.orders_columns'),
            'statusOptions' => $this->getOrderStatusOptions(),
        ]);
    }

    public function show(Order $order)
    {
        $order = $this->orderService->findByIdOrFail($order->id);

        return Inertia::render(SuperAdminPath::view('orders/Show'), [
            'order' => $order->load(['items.product', 'items.variant.color', 'items.variant.size']),
            'statusOptions' => $this->getOrderStatusOptions(),
        ]);
    }

    public function destroy(Order $order)
    {
        $this->orderService->delete($order);

        return $this->successWithToast(__('toast.deleted_successfully'), __('toast.success'), 'super-admin.orders.index');
    }

    public function changeStatus(Order $order)
    {
        $status = request('status');

        if (! $status) {
            return $this->errorWithToast(__('toast.status_is_required'), __('toast.error'), 'super-admin.orders.index');
        }

        try {
            $this->orderService->changeStatus($order, $status);

            return $this->successWithToast(__('toast.status_updated_successfully'), __('toast.success'), 'super-admin.orders.index');
        } catch (\Exception $e) {
            return $this->errorWithToast(__('toast.failed_to_update_order_status'), __('toast.error'), 'super-admin.orders.index');
        }
    }

    private function getOrderStatusOptions(): array
    {
        return [
            ['value' => OrderStatus::PENDING->value, 'label' => __('order.status.pending')],
            ['value' => OrderStatus::ACCEPTED->value, 'label' => __('order.status.accepted')],
            ['value' => OrderStatus::ON_THE_WAY->value, 'label' => __('order.status.on_the_way')],
            ['value' => OrderStatus::COMPLETED->value, 'label' => __('order.status.completed')],
            ['value' => OrderStatus::REJECTED->value, 'label' => __('order.status.rejected')],
            ['value' => OrderStatus::REFUNDED->value, 'label' => __('order.status.refunded')],
        ];
    }
}
