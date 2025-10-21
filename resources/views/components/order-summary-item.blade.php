@props([
    'image' => '',
    'name' => 'Product Name',
    'variant' => '',
    'quantity' => 1,
    'price' => '0.00',
    'link' => '#'
])

<tr class="order__summary--list">
    <td class="cart__table--body__list">
        <div class="product__image two d-flex align-items-center">
            <div class="product__thumbnail border-radius-5">
                <a class="display-block" href="{{ $link }}">
                    <img class="display-block border-radius-5" src="{{ asset($image) }}" alt="{{ $name }}">
                </a>
                <span class="product__thumbnail--quantity">{{ $quantity }}</span>
            </div>
            <div class="product__description">
                <h4 class="product__description--name">
                    <a href="{{ $link }}">{{ $name }}</a>
                </h4>
                @if($variant)
                    <span class="product__description--variant">{{ $variant }}</span>
                @endif
            </div>
        </div>
    </td>
    <td class="cart__table--body__list">
        <span class="cart__price">${{ $price }}</span>
    </td>
</tr>
