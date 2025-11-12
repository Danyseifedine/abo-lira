<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Services\Portal\CartServicePortal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function __construct(
        private CartServicePortal $cartService
    ) {}

    public function cart(Request $request): View|JsonResponse
    {
        $cartData = $this->cartService->getCart();

        // If request wants JSON (for minicart)
        if ($request->wantsJson() || $request->expectsJson()) {
            $html = view('components.modal-cart-product', [
                'cartItems' => $cartData['items'],
                'subtotal' => $cartData['subtotal_formatted'],
            ])->render();

            return response()->json([
                'success' => true,
                'subtotal' => $cartData['subtotal_formatted'],
                'html' => $html,
            ]);
        }

        // Return view for regular requests
        return view('cart', [
            'cartItems' => $cartData['items'],
            'subtotal' => $cartData['subtotal_formatted'],
            'cartItemsCount' => $this->cartService->getCartCount()
        ]);
    }

    public function addToCart(AddToCartRequest $request): JsonResponse
    {
        try {
            $this->cartService->addToCart($request->validated());

            return response()->json([
                'success' => true,
                'message' => __('cart.added_successfully'),
                'cartItemsCount' => $this->cartService->getCartCount()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function removeCartItem(string $itemId): JsonResponse
    {
        try {
            $result = $this->cartService->removeCartItem($itemId);

            return response()->json([
                'success' => true,
                'message' => __('cart.removed_successfully'),
                'data' => $result,
                'cartItemsCount' => $this->cartService->getCartCount()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function changeQuantity(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'itemId' => 'required|string',
            'action' => 'required|string|in:increase,decrease',
            'number' => 'required|integer|min:1',
        ]);

        try {
            $updatedItem = $this->cartService->changeQuantity($validated['itemId'], $validated['action'], $validated['number']);

            return response()->json([
                'success' => true,
                'message' => __('cart.quantity_changed_successfully'),
                'data' => $updatedItem,
                'cartItemsCount' => $this->cartService->getCartCount(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
