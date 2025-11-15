<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Portal\StoreOrderRequest;
use App\Services\Portal\CartServicePortal;
use App\Services\Portal\OrderServicePortal;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function __construct(
        private CartServicePortal $cartService,
        private OrderServicePortal $orderService,
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

        try {
            $orderNumber = $this->orderService->createOrder($request, $cartData);

            return redirect()->route('track-order', ['order_number' => $orderNumber])
                ->with('success', __('checkout.order_placed_success', ['orderNumber' => $orderNumber]));

        } catch (\Exception $e) {
            return redirect()->route('checkout')
                ->with('error', __('checkout.order_failed') . ' ' . $e->getMessage())
                ->withInput();
        }
    }
}
