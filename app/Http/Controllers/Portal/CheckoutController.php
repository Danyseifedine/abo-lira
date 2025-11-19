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
        $locale = app()->getLocale();

        $title = $locale === 'ar'
            ? 'إتمام الشراء | أبو ليرة - قطع غيار الدراجات النارية'
            : 'Checkout | Abo Lira - Motorcycle Parts';

        $description = $locale === 'ar'
            ? 'أكمل عملية الشراء الخاصة بك. قطع غيار دراجات نارية أصلية مع خدمة توصيل سريعة.'
            : 'Complete your purchase. Genuine motorcycle parts with fast delivery service.';

        seo_data([
            'title' => $title,
            'description' => $description,
            'type' => 'website',
        ]);

        seo_breadcrumb($locale === 'ar' ? 'سلة التسوق' : 'Shopping Cart', route('cart'));
        seo_breadcrumb($locale === 'ar' ? 'إتمام الشراء' : 'Checkout', route('checkout'));

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
                ->with('error', __('checkout.order_failed').' '.$e->getMessage())
                ->withInput();
        }
    }
}
