<?php

namespace App\Services\Portal;

use App\Enum\OrderStatus;
use App\Models\Order;
use App\Models\OrderHistory;
use App\Models\OrderItem;
use App\Models\Product;
use DB;
use Hnooz\LaravelCart\Facades\Cart;

class OrderServicePortal
{
    public function __construct(
        private CartServicePortal $cartService,
    ) {}

    public function createOrder($request, $cartData): string
    {
        $cartItems = $cartData['items'];

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
            'status' => OrderStatus::PENDING->value,
        ]);

        OrderHistory::create([
            'order_id' => $order->id,
            'status' => OrderStatus::PENDING->value,
        ]);

        // Fetch all products at once (optimized - avoids N+1 query problem)
        $slugs = collect($cartItems)->pluck('options.slug')->filter()->values();

        if ($slugs->isEmpty()) {
            throw new \Exception(__('checkout.no_product_slugs'));
        }

        $products = Product::whereIn('slug', $slugs)->get()->keyBy('slug');

        $this->createOrderItems($order, $cartItems, $products);

        $this->incrementBoughtCount($cartItems, $products);

        // Clear cart after successful order
        $this->cartService->clearCart();

        DB::commit();

        return $orderNumber;
    }

    private function createOrderItems($order, $cartItems, $products): void
    {
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
    }

    private function incrementBoughtCount($cartItems, $products): void
    {
        foreach ($cartItems as $item) {
            $slug = $item->options->slug ?? null;

            if (! $slug || ! isset($products[$slug])) {
                continue;
            }

            $product = $products[$slug];
            $product->bought_count += $item->quantity;
        }

        // Save all products with one DB trip total
        $products->each->save();
    }

    private function generateOrderNumber(): string
    {
        do {
            $timestamp = now()->format('Ymd');
            $random = str_pad((string) rand(0, 9999), 4, '0', STR_PAD_LEFT);
            $orderNumber = "ORD-{$timestamp}-{$random}";
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}
