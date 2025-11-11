@props([
'image' => '',
'name' => null,
'nameAr' => null,
'variants' => [],
'variantsAr' => [],
'quantity' => 1,
'price' => '0.00',
'link' => '#'
])

@php
$usedVariants = app()->getLocale() === 'ar' ? $variantsAr : $variants;
@endphp

<tr class="order__summary--list">
    <td class="cart__table--body__list">
        <div class="product__image two d-flex align-items-center {{ app()->getLocale() === 'ar' ? 'gap-3' : '' }}">
            <div class="product__thumbnail border-radius-5">
                <a class="display-block" href="{{ $link }}">
                    @if($image)
                        <img class="display-block border-radius-5" src="{{ asset($image) }}" alt="{{ app()->getLocale() === 'ar' ? $nameAr : $name }}" style="height: 80px; width: 100%; object-fit: cover;">
                    @else
                        <div class="d-flex justify-content-center align-items-center" style="height: 80px; width: 100%; background-color: #f0f0f0;">
                            <span class="text-muted" style="font-size: 1rem;">{{ __('detail.no_image') }}</span>
                        </div>
                    @endif
                </a>
                <span class="product__thumbnail--quantity">{{ $quantity }}</span>
            </div>
            <div class="product__description" style="margin-left: 0 !important;">
                <h4 class="product__description--name">
                    <a href="{{ $link }}">{{ app()->getLocale() === 'ar' ? $nameAr : $name }}</a>
                </h4>
                @if($usedVariants)
                <div class="d-flex flex-column">
                    @foreach($usedVariants as $variant)
                    <span class="product__description--variant" style="font-size: 1.1rem;">{{ $variant }}</span>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </td>
    <td class="cart__table--body__list">
        <span class="cart__price">${{ $price }}</span>
    </td>
</tr>