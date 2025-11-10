@props([
    'image' => '',
    'name' => 'Product Name',
    'variant' => 'Color: Default',
    'variants' => [],
    'currentPrice' => '0.00',
    'oldPrice' => null,
    'quantity' => 1,
    'link' => '#',
    'itemId' => ''
])

<div class="minicart__product--items d-flex" data-item-id="{{ $itemId }}">
    <div class="minicart__thumb">
        <a href="{{ $link }}"><img src="{{ asset($image) }}" alt="prduct-img"></a>
    </div>
    <div class="minicart__text">
        <h4 class="minicart__subtitle"><a href="{{ $link }}">{{ $name }}</a></h4>
        <span class="color__variant"><b>{{ $variant }}</b></span>
        <div class="minicart__price">
            <span class="minicart__current--price">$<span class="minicart-item-price" data-item-id="{{ $itemId }}">{{ $currentPrice }}</span></span>
            @if($oldPrice)
                <span class="minicart__old--price">${{ $oldPrice }}</span>
            @endif
        </div>
        <div class="minicart__text--footer d-flex align-items-center">
            <div class="quantity__box minicart__quantity">
                <button type="button" class="quantity__value decrease" data-item-id="{{ $itemId }}" aria-label="quantity value" value="Decrease Value">-</button>
                <label style="position: relative;">
                    <input type="number" class="quantity__number" value="{{ $quantity }}" data-item-id="{{ $itemId }}" data-counter readonly />
                    <span class="quantity__loading" data-item-id="{{ $itemId }}" style="display: none; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%); pointer-events: none;">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="animation: spin 1s linear infinite;">
                            <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" stroke-opacity="0.25"></circle>
                            <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" stroke-opacity="0.75"></path>
                        </svg>
                    </span>
                </label>
                <button type="button" class="quantity__value increase" data-item-id="{{ $itemId }}" aria-label="quantity value" value="Increase Value">+</button>
            </div>
            <button class="minicart__product--remove remove-cart-item" type="button" data-item-id="{{ $itemId }}" style="position: relative;">
                <span class="remove-icon" style="display: block;">Remove</span>
                <span class="remove-loading" data-item-id="{{ $itemId }}" style="display: none; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="animation: spin 1s linear infinite;">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" stroke-opacity="0.25"></circle>
                        <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" stroke-opacity="0.75"></path>
                    </svg>
                </span>
            </button>
        </div>
    </div>
</div>
