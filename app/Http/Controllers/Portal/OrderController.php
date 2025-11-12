<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Portal\CartServicePortal;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function __construct(
        private CartServicePortal $cartService
    ) {}

    public function trackOrder(Request $request): View
    {
        $cartItemsCount = $this->cartService->getCartCount();
        $orderNumber = $request->query('order_number');

        $order = null;
        if($orderNumber) {
            $order = Order::where('order_number', $orderNumber)->first();
            $order->created_at_formatted = Carbon::parse($order->created_at)->format('d/m/Y');
            $order->status_formatted = ucfirst($order->status);
        }

        return view('track-order', compact('cartItemsCount', 'order'));
    }

    public function getOrder(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'order_number' => 'required|string|max:255',
        ]);

        $orderNumber = $validated['order_number'];

        $order = Order::where('order_number', $orderNumber)->first();
        $order->created_at_formatted = Carbon::parse($order->created_at)->format('d/m/Y');
        $order->status_formatted = ucfirst($order->status);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => __('track_order.order_not_found'),
            ], 404);
        }

        return response()->json([
            'success' => true,
            'order' => $order,
        ]);
    }
}
