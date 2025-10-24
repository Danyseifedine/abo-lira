@props([
    'image' => '',
    'name' => 'Product Name',
    'variants' => [],
    'price' => '0.00',
    'quantity' => 1,
    'total' => '0.00',
    'link' => '#'
])

<tr class="cart__table--body__items">
    <td class="cart__table--body__list">
        <div class="cart__product d-flex align-items-center">
            <button class="cart__remove--btn" aria-label="search button" type="button">
                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 24 24" width="16px" height="16px"><path d="M 4.7070312 3.2929688 L 3.2929688 4.7070312 L 10.585938 12 L 3.2929688 19.292969 L 4.7070312 20.707031 L 12 13.414062 L 19.292969 20.707031 L 20.707031 19.292969 L 13.414062 12 L 20.707031 4.7070312 L 19.292969 3.2929688 L 12 10.585938 L 4.7070312 3.2929688 z"/></svg>
            </button>
            <div class="cart__thumbnail">
                <a href="{{ $link }}"><img class="border-radius-5" src="{{ asset($image) }}" alt="{{ $name }}"></a>
            </div>
            <div class="cart__content">
                <h3 class="cart__content--title h4"><a href="{{ $link }}">{{ $name }}</a></h3>
                @foreach($variants as $variant)
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
            <button type="button" class="quantity__value quickview__value--quantity decrease" aria-label="quantity value" value="Decrease Value">-</button>
            <label>
                <input type="number" class="quantity__number quickview__value--number" value="{{ $quantity }}" data-counter />
            </label>
            <button type="button" class="quantity__value quickview__value--quantity increase" aria-label="quantity value" value="Increase Value">+</button>
        </div>
    </td>
    <td class="cart__table--body__list">
        <span class="cart__price end">£{{ $total }}</span>
    </td>
</tr>
