@props([
    'slug' => '',
    'primaryImage' => '',
    'name' => 'Product Name',
    'currentPrice' => '0.00',
    'oldPrice' => null,
    'discount' => null,
    'description' => '',
])

<div class="col mb-30">
    <div class="product__card product__list d-flex align-items-center">
        <div class="product__card--thumbnail product__list--thumbnail" style="position: relative;">
            <a class="product__card--thumbnail__link display-block" href="{{ route('detail', ['slug' => $slug]) }}">
                <img class="w-100" src="{{ asset($primaryImage) }}" alt="{{ $name }}" style="max-height: 250px; object-fit: cover;">
            </a>
            @if($discount)
                <span class="product__badge">-{{ $discount }}%</span>
            @endif
        </div>
        <div class="product__card--content product__list--content">
            <h3 class="product__card--title"><a href="{{ route('detail', ['slug' => $slug]) }}">{{ $name }}</a></h3>
            <div class="product__list--price">
                <span class="current__price">${{ $currentPrice }}</span>
                @if($oldPrice)
                    <span class="old__price">${{ $oldPrice }}</span>
                @endif
            </div>
            @if($description)
                <p class="product__card--content__desc mb-20">{{ $description }}</p>
            @endif
            <a class="product__card--btn primary__btn" href="{{ route('detail', ['slug' => $slug]) }}">+ {{ __('shop.add_to_cart') }}</a>
        </div>
    </div>
</div>
