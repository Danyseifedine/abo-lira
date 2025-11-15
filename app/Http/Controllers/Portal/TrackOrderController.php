<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Services\Portal\CartServicePortal;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrackOrderController extends Controller
{
    public function __construct(
        private CartServicePortal $cartService
    ) {}

    public function trackOrder(Request $request): View
    {
        $cartItemsCount = $this->cartService->getCartCount();
        $orderNumber = $request->query('order_number');

        $data = [];
        if ($orderNumber) {
            $data = $this->getOrderDetails($orderNumber);
        }

        $order = $data['order'] ?? null;
        $orderHistories = $data['orderHistories'] ?? null;

        return view('track-order', compact('cartItemsCount', 'order', 'orderHistories'));
    }

    public function getOrder(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'order_number' => 'required|string|max:255',
        ]);

        $orderNumber = $validated['order_number'];

        $data = $this->getOrderDetails($orderNumber);

        $order = $data['order'] ?? null;
        $orderHistories = $data['orderHistories'] ?? null;

        if (! $order) {
            return response()->json([
                'success' => false,
                'message' => __('track_order.order_not_found'),
            ], 404);
        }

        return response()->json([
            'success' => true,
            'order' => $order,
            'orderHistories' => $orderHistories,
            'locale' => app()->getLocale(),
        ]);
    }

    private function getOrderDetails(string $orderNumber): array
    {
        $orderHistories = OrderHistory::whereHas('order', function ($query) use ($orderNumber) {
            $query->where('order_number', $orderNumber);
        })->orderBy('created_at', 'asc')->get();

        $orderHistories->transform(function ($history) {
            $history->status_formatted = $this->translateOrderStatus($history->status);
            $history->created_at_formatted = Carbon::parse($history->created_at)->format('d/m/Y');
            $history->created_at_time = Carbon::parse($history->created_at)->format('h:i A');

            return $history;
        });

        $order = Order::where('order_number', $orderNumber)->first();
        if ($order) {
            $order->created_at_formatted = Carbon::parse($order->created_at)->format('d/m/Y');
            $order->status_formatted = $this->translateOrderStatus($order->status);
        }

        return [
            'order' => $order,
            'orderHistories' => $orderHistories,
        ];
    }

    private function translateOrderStatus(string $status): string
    {
        $locale = app()->getLocale();

        switch ($status) {
            case 'pending':
                return $locale === 'ar' ? 'قيد الإنتظار' : 'Pending';
            case 'accepted':
                return $locale === 'ar' ? 'مقبول' : 'Accepted';
            case 'on_the_way':
                return $locale === 'ar' ? 'قيد التسليم' : 'On the Way';
            case 'completed':
                return $locale === 'ar' ? 'مكتمل' : 'Completed';
            case 'refunded':
                return $locale === 'ar' ? 'مسترجع' : 'Refunded';
            case 'rejected':
                return $locale === 'ar' ? 'مرفوض' : 'Rejected';
            default:
                return $status;
        }
    }
}
