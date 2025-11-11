    <div class="minicart__product">
        @forelse($cartItems as $item)
        <x-minicart-item
            :image="$item->image"
            :name="$item->name"
            :variants="$item->variants"
            :variantsAr="$item->variants_ar"
            :currentPrice="$item->price_formatted"
            :quantity="$item->quantity"
            :link="route('detail', ['slug' => $item->slug])"
            :itemId="$item->id" />
        @empty
        <div class="minicart__product--empty" style="padding-block: 40px; text-align: center;">
            <p>{{ __('nav.no_items_in_cart') }}</p>
        </div>
        @endforelse
        <div class="minicart__product--empty" id="cart-empty-container" style="display: none; padding-block: 40px; text-align: center;">
            <p>{{ __('nav.no_items_in_cart') }}</p>
        </div>
    </div>
    <div class="minicart__amount">
        <div class="minicart__amount_list d-flex justify-content-between">
            <span>{{ __('nav.total') }}</span>
            <span class="minicart-subtotal" id="cart-subtotal"><b>{{ $subtotal }}</b></span>
        </div>
    </div>
    <div class="minicart__button d-flex justify-content-center pt-3">
        <a class="primary__btn minicart__button--link" href="{{ route('cart') }}">{{ __('nav.view_cart') }}</a>
        <a class="primary__btn minicart__button--link disabled-on-fetch" href="{{ route('checkout') }}"
            @if($subtotal==0) style="pointer-events: none; opacity: 0.5; cursor: not-allowed;" @endif>
            {{ __('nav.checkout') }}
        </a>
    </div>