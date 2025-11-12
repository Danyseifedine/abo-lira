<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\StoreOrderRequest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\Portal\CartServicePortal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        private CartServicePortal $cartService
    ) {}

    public function checkout(): View
    {
        $cartCount = $this->cartService->getCartCount();

        $cartData = null;
        if ($cartCount !== 0) {
            $cartData = $this->cartService->getCart();
        }

        $cartItemsCount = $this->cartService->getCartCount();

        return view('checkout', compact('cartCount', 'cartData', 'cartItemsCount'));
    }

    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $cartCount = $this->cartService->getCartCount();

        if ($cartCount === 0) {
            return redirect()->route('checkout')
                ->with('error', __('checkout.cart_empty'));
        }

        $cartData = $this->cartService->getCart();
        $cartItems = $cartData['items'];

        try {
            DB::beginTransaction();

            // Generate unique order number
            $orderNumber = $this->generateOrderNumber();

            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'f_name' => $request->input('f_name'),
                'l_name' => $request->input('l_name'),
                'phone_number' => $request->input('phone_number'),
                'address' => $request->input('address'),
                'city' => $request->input('city'),
                'total_amount' => $cartData['subtotal_formatted'],
                'status' => 'pending',
            ]);

            // Fetch all products at once (optimized - avoids N+1 query problem)
            $slugs = collect($cartItems)->pluck('options.slug')->filter()->values();

            if ($slugs->isEmpty()) {
                throw new \Exception(__('checkout.no_product_slugs'));
            }

            $products = Product::whereIn('slug', $slugs)->get()->keyBy('slug');

            // Prepare order items for bulk insert
            $orderItems = [];

            foreach ($cartItems as $item) {
                $slug = $item->options->slug ?? $item->slug ?? null;

                if (! $slug) {
                    throw new \Exception(__('checkout.product_slug_not_found'));
                }

                $product = $products->get($slug);

                if (! $product) {
                    throw new \Exception(__('checkout.product_not_found', ['slug' => $slug]));
                }

                $orderItems[] = [
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'variant_id' => $item->options->variant_id ?? null,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Bulk insert all order items at once
            OrderItem::insert($orderItems);

            // Clear cart after successful order
            $this->cartService->clearCart();

            DB::commit();

            return redirect()->route('track-order', ['order_number' => $orderNumber])
                ->with('success', __('checkout.order_placed_success', ['orderNumber' => $orderNumber]));
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('checkout')
                ->with('error', __('checkout.order_failed') . ' ' . $e->getMessage())
                ->withInput();
        }
    }

    private function generateOrderNumber(): string
    {
        do {
            $timestamp = now()->format('YmdHis');
            $random = str_pad((string) rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $orderNumber = "ORD-{$timestamp}-{$random}";
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}
