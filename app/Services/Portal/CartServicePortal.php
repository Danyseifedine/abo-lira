<?php

namespace App\Services\Portal;

use Hnooz\LaravelCart\Facades\Cart;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CartServicePortal
{
    public function __construct(
        private ProductServicePortal $productService,
    ) {}

    public function addToCart(array $request): void
    {
        $product = $this->productService->getProductDetails($request['slug']);
        if (! $product) {
            throw new \Exception('Product not found');
            return;
        }

        // Get variant by ID (required and most direct)
        $variant = $product->variants->firstWhere('id', $request['variant_id']);

        if (! $variant) {
            throw new \Exception('Product variant not found');
            return;
        }

        // Validate that color and size match the variant if provided
        $hasColor = isset($request['color_id']);
        $hasSize = isset($request['size_id']);

        if ($hasColor) {
            $colorId = $variant->color?->id;
            if ($colorId !== (int) $request['color_id']) {
                throw new \Exception('Selected color does not match the variant.');
                return;
            }
        }

        if ($hasSize) {
            $sizeId = $variant->size?->id;
            if ($sizeId !== (int) $request['size_id']) {
                throw new \Exception('Selected size does not match the variant.');
                return;
            }
        }

        // Get base price from variant
        $basePrice = (float) $variant->price;

        // Calculate discount if product has discount
        $discountAmount = (float) ($product->discount_price ?? 0);
        $discountCalculation = $this->productService->calculateDiscount($basePrice, $discountAmount);
        $finalPrice = $discountCalculation['new_price'];

        // Get image based on scenarios
        $image = null;
        if ($hasColor && $hasSize) {
            $image = $variant->image;
            if (empty($image)) {
                $image = $product->image;
            }
        } elseif ($hasColor && ! $hasSize) {
            $image = $variant->image;
            if (empty($image)) {
                $image = $product->image;
            }
        } elseif (! $hasColor && $hasSize) {
            $image = $product->image;
        } else {
            $image = $variant->image;
            if (empty($image)) {
                $image = $product->image;
            }
        }

        // Build variants array for display (English)
        $variants = [];
        if ($variant->color?->name_en) {
            $variants[] = 'COLOR: ' . $variant->color->name_en;
        }
        if ($variant->size?->name_en) {
            $variants[] = 'SIZE: ' . $variant->size->name_en;
        }

        // Build variants array for display (Arabic)
        $variantsAr = [];
        if ($variant->color?->name_ar) {
            $variantsAr[] = 'اللون: ' . $variant->color->name_ar;
        }
        if ($variant->size?->name_ar) {
            $variantsAr[] = 'المقاس: ' . $variant->size->name_ar;
        }

        // Prepare options array with additional data
        $options = [
            'slug' => $product->slug,
            'image' => $image,
            'color' => $variant->color?->name_en ?? null,
            'color_ar' => $variant->color?->name_ar ?? null,
            'color_code' => $variant->color?->code ?? null,
            'size' => $variant->size?->name_en ?? null,
            'size_ar' => $variant->size?->name_ar ?? null,
            'variants' => $variants,
            'variants_ar' => $variantsAr,
            'name_ar' => $product->name_ar,
            'variant_id' => $variant->id,
            'color_id' => $variant->color_id,
            'size_id' => $variant->size_id,
        ];

        // Create unique item ID by combining variant_id, color_id, and size_id
        // This ensures same variant with different color/size are separate items
        $itemIdParts = [(string) $variant->id];
        if ($variant->color_id) {
            $itemIdParts[] = 'c' . $variant->color_id;
        }
        if ($variant->size_id) {
            $itemIdParts[] = 's' . $variant->size_id;
        }
        $itemId = implode('-', $itemIdParts);

        // Add to cart using the Cart facade
        // Store product name in English (we'll use name_ar from options when needed)
        Cart::add(
            $itemId,
            $product->name_en,
            $finalPrice,
            $request['quantity'],
            $options
        );
    }

    public function getCart(): array
    {
        $cartItems = Cart::all();

        $formattedItems = collect($cartItems)->map(function ($item, $itemId) {
            // Calculate total
            $total = number_format((float) $item['price'] * (int) $item['quantity'], 2, '.', '');

            // Format price
            $priceFormatted = number_format((float) $item['price'], 2, '.', '');

            // Get image (can be full URL or relative path)
            $image = $item['options']['image'] ?? 'assets/img/product/small-product/product9.webp';

            // Return as object for easy access in Blade
            return (object) [
                'id' => $itemId,
                'name' => $item['name'],
                'name_ar' => $item['options']['name_ar'] ?? null,
                'price' => (float) $item['price'],
                'price_formatted' => $priceFormatted,
                'quantity' => (int) $item['quantity'],
                'total' => $total,
                'image' => $image,
                'slug' => $item['options']['slug'],
                'variants' => $item['options']['variants'] ?? [],
                'variants_ar' => $item['options']['variants_ar'] ?? [],
                'options' => (object) ($item['options'] ?? []),
            ];
        });

        // Calculate subtotal
        $subtotal = $formattedItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return [
            'items' => $formattedItems->values()->toArray(),
            'subtotal_formatted' => number_format($subtotal, 2, '.', ''),
        ];
    }

    public function removeCartItem(string $itemId): array
    {
        Cart::remove($itemId);

        // Get updated cart data after removal
        $cartData = $this->getCart();

        return [
            'subtotal' => $cartData['subtotal_formatted'],
            'items_count' => count($cartData['items']),
        ];
    }

    public function changeQuantity(string $itemId, string $action, int $number = 1): array
    {
        if ($action === 'increase') {
            Cart::increase($itemId, $number);
        } else if ($action === 'decrease') {
            Cart::decrease($itemId, $number);
        }

        // Get updated cart data
        $cartData = $this->getCart();

        // Find the updated item (items is now an array)
        $updatedItem = collect($cartData['items'])->firstWhere('id', $itemId);

        if (!$updatedItem) {
            throw new \Exception('Item not found in cart');
        }

        $data = [
            'item' => [
                'quantity' => $updatedItem->quantity,
                'total' => $updatedItem->total,
                'price_formatted' => $updatedItem->price_formatted,
            ],
            'subtotal' => $cartData['subtotal_formatted'],
        ];

        return $data;
    }

    public function getCartCount(): int
    {
        return Cart::count();
    }

    public function clearCart(): void
    {
        Cart::clear();
    }
}
