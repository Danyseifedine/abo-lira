@props([
    'image' => '',
    'name' => null,
    'nameAr' => null,
    'variantsAr' => [],
    'variants' => [],
    'currentPrice' => '0.00',
    'oldPrice' => null,
    'quantity' => 1,
    'link' => '#',
    'itemId' => ''
])

@php
    $usedVariants = app()->getLocale() === 'ar' ? $variantsAr : $variants;
@endphp

<div class="minicart__product--items d-flex {{ app()->getLocale() === 'ar' ? 'gap-3' : '' }}" data-item-id="{{ $itemId }}" id="parent-cart-item">
    <div class="minicart__thumb" style="margin: 0 !important;">
        <a href="{{ $link }}">
            @if($image)
            <img src="{{ asset($image) }}" alt="prduct-img" style="height: 140px !important; object-fit: cover;"></a>
            @else
                <div class="d-flex justify-content-center align-items-center" style="height: 170px; width: 105px; background-color: #f0f0f0;">
                    <span class="text-muted" style="font-size: 1.4rem;">{{ __('detail.no_image') }}</span>
                </div>
            @endif
    </div>
    <div class="minicart__text" style="margin: 0 !important;">
        <h4 class="minicart__subtitle"><a href="{{ $link }}">{{ app()->getLocale() === 'ar' ? $nameAr : $name }}</a></h4>
        <div class="d-flex flex-column">
            @foreach($usedVariants as $variant)
                <span class="color__variant" style="color: var(--foreground-sub-color); font-size: 1.4rem;">{{ $variant }}</span>
            @endforeach
        </div>
        <div class="minicart__price">
            <span class="minicart__current--price">$<span class="minicart-item-price" id="cart-item-total" data-item-id="{{ $itemId }}">{{ $currentPrice }}</span></span>
            @if($oldPrice)
                <span class="minicart__old--price">${{ $oldPrice }}</span>
            @endif
        </div>
        <div class="minicart__text--footer d-flex align-items-center gap-3">
            <div class="quantity__box minicart__quantity" style="margin: 0 !important;">
                <button type="button" class="quantity__value decrease disabled-on-fetch" id="cart-decrease-quantity" data-item-id="{{ $itemId }}" aria-label="{{ __('nav.quantity_value') }}" value="{{ __('nav.decrease_value') }}">-</button>
                <label style="position: relative;">
                    <input type="number" class="quantity__number" value="{{ $quantity }}" id="input-cart-quantity" data-item-id="{{ $itemId }}" data-counter readonly />
                    <span class="quantity__loading" data-item-id="{{ $itemId }}" id="cart-quantity-loading" style="display: none; padding: 3px; pointer-events: none;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="animation: spin 1s linear infinite;">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" stroke-opacity="0.25"></circle>
                            <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" stroke-opacity="0.75"></path>
                        </svg>
                    </span>
                </label>
                <button type="button" class="quantity__value increase disabled-on-fetch" id="cart-increase-quantity" data-item-id="{{ $itemId }}" aria-label="{{ __('nav.quantity_value') }}" value="{{ __('nav.increase_value') }}">+</button>
            </div>
            <button class="minicart__product--remove remove-cart-item disabled-on-fetch" type="button" id="cart-remove-btn" data-item-id="{{ $itemId }}" style="position: relative; margin: 0 !important;">
                <span class="remove-icon disabled-on-fetch" style="display: block;" id="cart-remove-icon">{{ __('nav.remove') }}</span>
                <span class="remove-loading" data-item-id="{{ $itemId }}" id="cart-remove-loading" style="display: none; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="animation: spin 1s linear infinite;">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" stroke-opacity="0.25"></circle>
                        <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" stroke-opacity="0.75"></path>
                    </svg>
                </span>
            </button>
        </div>
    </div>
</div>
