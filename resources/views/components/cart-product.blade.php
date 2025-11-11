@props([
'image' => '',
'name' => 'Product Name',
'nameAr' => null,
'variants' => [],
'variantsAr' => [],
'price' => '0.00',
'quantity' => 1,
'total' => '0.00',
'link' => '#',
'itemId' => ''
])

@php
    $isArabic = app()->getLocale() === 'ar';
    $displayName = $isArabic && $nameAr ? $nameAr : $name;
    $displayVariants = $isArabic && !empty($variantsAr) ? $variantsAr : $variants;
@endphp

<tr class="cart__table--body__items" data-item-id="{{ $itemId }}" id="parent-cart-item">
    <td class="cart__table--body__list">
        <div class="cart__product d-flex align-items-center">
            <button type="button" class="cart__remove--btn remove-cart-item disabled-on-fetch" id="cart-remove-btn" data-item-id="{{ $itemId }}" aria-label="Remove item" style="position: relative;">
                <svg class="remove-icon" id="cart-remove-icon" data-item-id="{{ $itemId }}" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16px" height="16px" style="display: block; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);">
                    <path d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 L 12 10.585938 L 4.7070312 3.2929688 z" />
                </svg>
                <span class="remove-loading" id="cart-remove-loading" data-item-id="{{ $itemId }}" style="display: none; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="animation: spin 1s linear infinite;">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" stroke-opacity="0.25"></circle>
                        <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" stroke-opacity="0.75"></path>
                    </svg>
                </span>
            </button>
            <div class="cart__thumbnail">
                <a href="{{ $link }}"><img class="border-radius-5" src="{{ asset($image) }}" alt="{{ $displayName }}" style="height: 130px; object-fit: cover;"></a>
            </div>
            <div class="cart__content">
                <h3 class="cart__content--title h4"><a href="{{ $link }}">{{ $displayName }}</a></h3>
                @foreach($displayVariants as $variant)
                <span class="cart__content--variant">{{ $variant }}</span>
                @endforeach
            </div>
        </div>
    </td>
    <td class="cart__table--body__list">
        <span class="cart__price">${{ $price }}</span>
    </td>
    <td class="cart__table--body__list">
        <div class="quantity__box">
            <button type="button" class="quantity__value quickview__value--quantity decrease disabled-on-fetch" id="cart-decrease-quantity" data-item-id="{{ $itemId }}" aria-label="Decrease quantity">-</button>
            <label style="position: relative;">
                <input type="number" class="quantity__number quickview__value--number" id="input-cart-quantity" value="{{ $quantity }}" data-item-id="{{ $itemId }}" min="1" readonly />
                <span class="quantity__loading" id="cart-quantity-loading" data-item-id="{{ $itemId }}" style="display: none; pointer-events: none; padding: 4px; background-color: #fff;">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="animation: spin 1s linear infinite;">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" stroke-opacity="0.25"></circle>
                        <path fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" stroke-opacity="0.75"></path>
                    </svg>
                </span>
            </label>
            <button type="button" class="quantity__value quickview__value--quantity increase disabled-on-fetch" id="cart-increase-quantity" data-item-id="{{ $itemId }}" aria-label="Increase quantity">+</button>
        </div>
    </td>
    <td class="cart__table--body__list">
        <span class="cart__price end cart-item-total" id="cart-item-total" data-item-id="{{ $itemId }}">{{ $total }}$</span>
    </td>
</tr>