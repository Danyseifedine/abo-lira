@extends('layout.master')

@section('content')

<main class="main__content_wrapper">

    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <nav aria-label="breadcrumb">
                            <div class="d-flex align-items-center justify-content-center gap-3 flex-wrap" @if(app()->getLocale() === 'ar') dir="rtl" @endif>
                                <a href="{{ route('home') }}" class="text-decoration-none breadcrumb-link" style="font-size: 15px; line-height: 22px; color: #333; transition: color 0.3s ease;">{{ __('nav.home') }}</a>
                                <span style="color: var(--secondary-color, #dc3545); font-size: 15px; line-height: 22px; user-select: none;">/</span>
                                <span class="fw-medium" style="font-size: 15px; line-height: 22px; color: #333;" aria-current="page">{{ __('checkout.checkout') }}</span>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->

    <!-- Start checkout page area -->
    <div class="checkout__page--area section--padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 col-md-6">
                    <div class="main checkout__mian">
                        <form id="checkout-form" action="{{ route('checkout.store') }}" method="POST">
                            @csrf
                            @if(session('success'))
                                <div class="alert alert-success mb-4">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger mb-4">
                                    {{ session('error') }}
                                </div>
                            @endif
                            @if($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="checkout__content--step section__contact--information">
                                <div class="section__header checkout__section--header d-flex align-items-center justify-content-between mb-10">
                                    <h2 class="section__header--title h3">{{ __('checkout.phone_number') }} <span class="checkout__input--label__star">*</span></h2>
                                </div>
                                <div class="customer__information">
                                    <div class="checkout__email--phone mb-12">
                                        <label class="d-flex align-items-center" style="position: relative; direction: ltr;">
                                            <span class="d-flex justify-content-center align-items-center"
                                             style="width: 50px; position: absolute; left: 0; top: 0; bottom: 0; margin: auto;">+961
                                            </span>
                                            <input class="checkout__input--field border-radius-5" name="phone_number" placeholder="{{ __('checkout.phone_number_placeholder') }}" type="text" value="{{ old('phone_number') }}" style="padding-left: 50px;" required>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="checkout__content--step section__shipping--address">
                                <div class="section__header mb-25">
                                    <h2 class="section__header--title h3">{{ __('checkout.billing_details') }}</h2>
                                </div>
                                <div class="section__shipping--address__content">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 mb-20">
                                            <div class="checkout__input--list ">
                                                <label class="checkout__input--label mb-1" for="input1">{{ __('checkout.first_name') }} <span class="checkout__input--label__star">*</span></label>
                                                <input class="checkout__input--field border-radius-5" name="f_name" placeholder="{{ __('checkout.first_name_placeholder') }}" id="input1" type="text" value="{{ old('f_name') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 mb-20">
                                            <div class="checkout__input--list">
                                                <label class="checkout__input--label mb-1" for="input2">{{ __('checkout.last_name') }} <span class="checkout__input--label__star">*</span></label>
                                                <input class="checkout__input--field border-radius-5" name="l_name" placeholder="{{ __('checkout.last_name_placeholder') }}" id="input2" type="text" value="{{ old('l_name') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-20">
                                            <div class="checkout__input--list">
                                                <label class="checkout__input--label mb-1" for="input4">{{ __('checkout.address') }} <span class="checkout__input--label__star">*</span></label>
                                                <input class="checkout__input--field border-radius-5" name="address" placeholder="{{ __('checkout.address_placeholder') }}" id="input4" type="text" value="{{ old('address') }}" required>
                                            </div>
                                        </div>

                                        <div class="col-12 mb-20">
                                            <div class="checkout__input--list">
                                                <label class="checkout__input--label mb-1" for="input5">{{ __('checkout.town_city') }} <span class="checkout__input--label__star">*</span></label>
                                                <input class="checkout__input--field border-radius-5" name="city" placeholder="{{ __('checkout.city_placeholder') }}" id="input5" type="text" value="{{ old('city') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="checkout__content--step__footer d-flex align-items-center">
                                <a class="continue__shipping--btn primary__btn border-radius-5" href="{{ route('home') }}">{{ __('checkout.back_home') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6">
                    <aside class="checkout__sidebar sidebar border-radius-10">
                        <h2 class="checkout__order--summary__title text-center mb-15 d-flex justify-content-center align-items-center gap-2">
                            {{ __('checkout.your_order_summary') }}
                        </h2>
                        <div class="cart__table checkout__product--table" style="max-height: 250px; overflow-y: auto;">
                            @if($cartCount !== 0)
                            <table class="cart__table--inner">
                                <tbody class="cart__table--body">
                                    @foreach($cartData['items'] as $item)
                                    <x-order-summary-item
                                        :image="$item->image"
                                        :name="$item->name"
                                        :nameAr="$item->name_ar"
                                        :variants="$item->variants"
                                        :variantsAr="$item->variants_ar"
                                        :quantity="$item->quantity"
                                        :price="$item->price_formatted"
                                        :link="route('detail', ['slug' => $item->slug])" 
                                        />

                                </tbody>
                                @endforeach
                            </table>
                            @else
                            <div class="text-center py-5">
                                <p class="mb-0">{{ __('cart.empty_cart') }}</p>
                                <a href="{{ route('shop') }}" class="primary__btn mt-3">{{ __('cart.continue_shopping') }}</a>
                            </div>
                            @endif
                        </div>
                        <div class="payment__history mb-30">
                            <div class="d-flex flex-column align-items-center">
                                <span class="payment__history--title mb-5">{{ __('checkout.total') }}</span>
                                <span class="payment__history--amount fw-bold" style="font-size:2.5rem; color:#2b2b2b; letter-spacing:1px;">
                                    {{   $cartCount !== 0 ? $cartData['subtotal_formatted'] : '0.00' }}$
                                </span>
                            </div>
                        </div>
                        <button class="checkout__now--btn primary__btn" id="submit-checkout-btn" style="{{ $cartCount == 0 ? 'pointer-events: none; opacity: 0.5; cursor: not-allowed;' : '' }}" type="submit" form="checkout-form" 
                        {{ $cartCount == 0 ? 'disabled' : '' }}>{{ __('checkout.checkout_now') }}</button>
                    </aside>
                </div>

            </div>
        </div>
    </div>
    <!-- End checkout page area -->
</main>

@push('scripts')
<script>
    document.getElementById('checkout-form').addEventListener('submit', function() {
        const submitBtn = document.getElementById('submit-checkout-btn');
        submitBtn.style.opacity = '0.5';
        submitBtn.disabled = true;
    });
</script>
@endpush

@endsection