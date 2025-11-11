@extends('layout.master')
@section('content')
<main class="main__content_wrapper">

    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title mb-25">{{ __('cart.title') }}</h1>
                        <nav aria-label="breadcrumb">
                            <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap" @if(app()->getLocale() === 'ar') dir="rtl" @endif>
                                <a href="{{ route('home') }}" class="text-decoration-none breadcrumb-link" style="font-size: 15px; line-height: 22px; color: #333; transition: color 0.3s ease;">{{ __('cart.home') }}</a>
                                <span style="color: var(--secondary-color, #dc3545); font-size: 15px; line-height: 22px; user-select: none;">/</span>
                                <span class="fw-medium" style="font-size: 15px; line-height: 22px; color: #333;" aria-current="page">{{ __('cart.shopping_cart') }}</span>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->

    <!-- cart section start -->
    <section class="cart__section section--padding">
        <div class="container-fluid">
            <!-- Hidden div for cart translations and routes -->
            <div class="cart__section--inner">
                <form action="#">
                    <h2 class="cart__title mb-30">{{ __('cart.shopping_cart') }}</h2>
                    <!-- Products Section - Full Width -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="cart__table">
                                <table class="cart__table--inner">
                                    <thead class="cart__table--header">
                                        <tr class="cart__table--header__items">
                                            <th class="cart__table--header__list">{{ __('cart.product') }}</th>
                                            <th class="cart__table--header__list">{{ __('cart.price') }}</th>
                                            <th class="cart__table--header__list">{{ __('cart.quantity') }}</th>
                                            <th class="cart__table--header__list">{{ __('cart.total') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="cart__table--body">
                                        @forelse($cartItems as $item)
                                        <x-cart-product
                                            :image="$item->image"
                                            :name="$item->name"
                                            :nameAr="$item->name_ar"
                                            :variants="$item->variants"
                                            :variantsAr="$item->variants_ar"
                                            :price="$item->price_formatted"
                                            :quantity="$item->quantity"
                                            :total="$item->total"
                                            :link="route('detail', ['slug' => $item->slug])"
                                            :itemId="$item->id" />
                                        @empty
                                        <tr class="cart__table--body__items">
                                            <td colspan="4" class="text-center py-5">
                                                <p class="mb-0">{{ __('cart.empty_cart') }}</p>
                                                <a href="{{ route('shop') }}" class="primary__btn mt-3">{{ __('cart.continue_shopping') }}</a>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="w-100 text-center py-5" id="cart-empty-container" style="display: none;">
                                    <p class="mb-0">{{ __('cart.empty_cart') }}</p>
                                    <a href="{{ route('shop') }}" class="primary__btn mt-3">{{ __('cart.continue_shopping') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Subtotal Section - Centered -->
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-8">
                            <div class="cart__summary border-radius-10 text-center">
                                <div class="cart__summary--total mb-20">
                                    <div class="text-center" style="padding: 20px; background: #f8f9fa; border-radius: 8px; border: 2px solid #dc3545;">
                                        <div style="font-size: 1.8rem; font-weight: 800; color: #2c3e50; margin-bottom: 8px; text-transform: uppercase;">{{ __('cart.subtotal') }}</div>
                                        <div style="font-size: 2rem; font-weight: 700; color: #dc3545;" id="cart-subtotal">{{ $subtotal }}$</div>
                                    </div>
                                </div>
                                <div class="cart__summary--footer">
                                    <ul class="d-flex justify-content-center gap-3">
                                        <li><a class="cart__summary--footer__btn primary__btn checkout disabled-on-fetch" href="{{ route('checkout') }}" id="checkout-btn" 
                                        @if($subtotal==0) style="pointer-events: none; opacity: 0.5; cursor: not-allowed;" @endif>
                                        {{ __('cart.checkout') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- cart section end -->

    @push('styles')
    <style>
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .quantity__loading svg {
            color: #dc3545;
        }

        /* Arabic (RTL) specific styles */
        [dir="rtl"] .cart__table--inner {
            width: 100%;
        }

        [dir="rtl"] .cart__table--header__list {
            padding: 0 0 2rem 2rem;
            text-align: right;
            vertical-align: middle;
        }

        [dir="rtl"] .cart__table--header__list:first-child {
            padding-right: 2rem;
            padding-left: 0;
        }

        [dir="rtl"] .cart__table--header__list:last-child {
            padding-left: 0;
        }

        [dir="rtl"] .cart__table--body__list {
            padding: 2rem 0 2rem 2rem;
            text-align: right;
            vertical-align: middle;
        }

        [dir="rtl"] .cart__table--body__list:first-child {
            padding-right: 2rem;
            padding-left: 0;
            text-align: right;
        }

        [dir="rtl"] .cart__table--body__list:last-child {
            padding-left: 0;
            text-align: right;
        }

        [dir="rtl"] .cart__product {
            flex-direction: row;
            direction: rtl;
        }

        [dir="rtl"] .cart__remove--btn {
            margin-right: 0;
            margin-left: 1.5rem;
        }

        @media only screen and (min-width: 992px) {
            [dir="rtl"] .cart__remove--btn {
                margin-left: 3rem;
            }
        }

        [dir="rtl"] .cart__thumbnail {
            margin-left: 0;
            margin-right: 0;
        }

        [dir="rtl"] .cart__content {
            padding-left: 0;
            padding-right: 1.5rem;
            direction: rtl;
            text-align: right;
        }

        @media only screen and (min-width: 1200px) {
            [dir="rtl"] .cart__content {
                padding-right: 2rem;
            }
        }

        [dir="rtl"] .cart__content--title {
            text-align: right;
        }

        [dir="rtl"] .cart__content--variant {
            text-align: right;
        }

        [dir="rtl"] .quantity__box {
            display: flex;
            gap: 0.5rem;
            justify-content: flex-end;
            align-items: center;
            direction: ltr;
        }

        [dir="rtl"] .quantity__value {
            border-radius: 3px !important;
        }

        [dir="rtl"] .quantity__value.decrease {
            order: 3;
            margin-right: 0 !important;
            margin-left: -4px !important;
            border-radius: 0 13px 13px 0 !important;
        }

        [dir="rtl"] .quantity__value.increase {
            order: 1;
            margin-left: 0 !important;
            margin-right: -4px !important;
            border-radius: 13px 0 0 13px !important;
        }

        [dir="rtl"] .quantity__box label {
            order: 2;
        }

        [dir="rtl"] .cart__price {
            text-align: right;
        }

        [dir="rtl"] .cart__price.end {
            text-align: right;
        }

        @media (max-width: 767px) {
            [dir="rtl"] .quantity__box {
                gap: 0.75rem;
            }
        }
    </style>
    @endpush
</main>
@endsection