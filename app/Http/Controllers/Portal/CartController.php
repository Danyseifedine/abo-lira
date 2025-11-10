<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Services\Portal\CartServicePortal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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
            return response()->json([
                'success' => true,
                'data' => $cartData,
            ]);
        }

        // Return view for regular requests
        return view('cart', [
            'cartItems' => $cartData['items'],
            'subtotal' => $cartData['subtotal_formatted'],
        ]);
    }

    public function addToCart(AddToCartRequest $request): RedirectResponse
    {
        try {
            $this->cartService->addToCart($request->validated());

            return redirect()->back()->with('success', 'Product added to cart successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function removeCartItem(string $itemId): JsonResponse
    {
        try {
            $result = $this->cartService->removeCartItem($itemId);

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart successfully!',
                'data' => $result,
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
                'message' => 'Quantity changed successfully!',
                'data' => $updatedItem,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function checkout(): View
    {
        return view('checkout');
    }
}
