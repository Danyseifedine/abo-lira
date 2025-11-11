@props([
    'slug' => '',
    'primaryImage' => '',
    'name' => 'Product Name',
    'description' => null,
    'price' => '0.00',
    'basePrice' => '0.00',
    'oldPrice' => null,
    'discountPercentage' => null,
    'category' => null,
    'quality' => null,
    'hasMultipleVariants' => false,
    'is_discounted' => false,
])

<div class="swiper-slide">
    <article class="product__card" style="height: 100%; display: flex; flex-direction: column;">
        <div class="product__card--thumbnail">
            <a class="product__card--thumbnail__link display-block" href="{{ route('detail', ['slug' => $slug]) }}">
                <img src="{{ asset('assets/img/abo-lira/empty.webp') }}"
                    @if ($primaryImage) data-src="{{ asset($primaryImage) }}" @endif
                    alt="{{ $name }}{{ $category ? ' - ' . $category : '' }}{{ $quality ? ' - ' . $quality : '' }}{{ $description ? ' – ' . Str::limit(strip_tags($description), 80) : '' }}"
                    class="product__card--image"
                    style="height: 250px; width: 100%; object-fit: cover; border-radius: 8px; display: block; opacity: 1;"
                    title="{{ $name }}{{ $category ? ' in ' . $category : '' }}{{ $quality ? ' (' . $quality . ')' : '' }}"
                    @if ($basePrice) data-product-price="{{ $basePrice }}" @endif
                    @if (isset($discount) && $discount) data-discount="{{ $discount }}" @endif
                    @if ($category) data-category="{{ $category }}" @endif
                    @if ($quality) data-quality="{{ $quality }}" @endif
                    @if ($hasMultipleVariants) data-has-multiple-variants="true" @endif itemprop="image">
            </a>
            @if ($is_discounted && $discountPercentage && $discountPercentage > 0)
                <span class="product__badge">-{{ number_format($discountPercentage, 0) }}%</span>
            @endif
        </div>
        <div class="product__card--content" style="flex: 1; display: flex; flex-direction: column; padding-top: 8px;">
            <!-- Tags Section -->
            <div class="product__card--tags"
                style="display: flex; gap: 4px; flex-wrap: wrap; margin-bottom: 8px; min-height: 20px;">
                @if ($quality)
                    <span
                        style="display: inline-block; padding: 2px 6px; background: #e3f2fd; color: #1976d2; border-radius: 3px; font-size: 9px; font-weight: 700; text-transform: uppercase;">{{ $quality }}</span>
                @endif
                @if ($category)
                    <span
                        style="display: inline-block; padding: 2px 6px; background: #f3e5f5; color: #7b1fa2; border-radius: 3px; font-size: 9px; font-weight: 700; text-transform: uppercase;">{{ $category }}</span>
                @endif
                @if ($hasMultipleVariants)
                    <span
                        style="display: inline-flex; align-items: center; gap: 2px; padding: 2px 6px; background: #fff3e0; color: #e65100; border-radius: 3px; font-size: 9px; font-weight: 700; text-transform: uppercase;">
                        Colors
                    </span>
                @endif
            </div>

            <h3 class="product__card--title"
                style="min-height: 44px; margin: 0 0 8px 0; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; line-height: 1.4;">
                <a href="{{ route('detail', ['slug' => $slug]) }}">{{ $name }}</a>
            </h3>

            <p class="product__card--description"
                style="font-size: 12px; color: #666; line-height: 1.4; margin: 0 0 8px 0; min-height: 34px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                {{ $description ?? '' }}
            </p>

            <div class="product__card--price" style="margin-top: 8px;">
                @if ($is_discounted && $discountPercentage && $discountPercentage > 0)
                    <div class="d-flex align-items-center gap-3">
                        <span class="current__price"
                            style="color: #e74c3c; font-weight: 700; font-size: 16px;">${{ number_format($price, 2) }}</span>
                        <span
                            style="text-decoration: line-through; color: #999; font-weight: 400; font-size: 14px;">${{ number_format($basePrice, 2) }}</span>
                    </div>
                @else
                    <span class="current__price"
                        style="color: #e74c3c; font-weight: 600; font-size: 16px;">${{ number_format($basePrice, 2) }}</span>
                @endif
            </div>
            <div class="product__card--footer" style="margin-top: auto;">
                <a class="product__card--btn primary__btn d-flex justify-content-center align-items-center gap-2" href="{{ route('detail', ['slug' => $slug]) }}">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/>
                        <path d="M12 8V12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <circle cx="12" cy="16" r="1" fill="currentColor"/>
                    </svg>
                    <span>{{ __('shop.details') }}</span>
                </a>
            </div>
        </div>
    </article>
</div>
