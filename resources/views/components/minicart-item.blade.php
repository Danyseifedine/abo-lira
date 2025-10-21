@props([
    'image' => '',
    'name' => 'Product Name',
    'variant' => 'Color: Default',
    'currentPrice' => '0.00',
    'oldPrice' => null,
    'quantity' => 1,
    'link' => '#'
])

<div class="minicart__product--items d-flex">
    <div class="minicart__thumb">
        <a href="{{ $link }}"><img src="{{ asset($image) }}" alt="prduct-img"></a>
    </div>
    <div class="minicart__text">
        <h4 class="minicart__subtitle"><a href="{{ $link }}">{{ $name }}</a></h4>
        <span class="color__variant"><b>{{ $variant }}</b></span>
        <div class="minicart__price">
            <span class="minicart__current--price">${{ $currentPrice }}</span>
            @if($oldPrice)
                <span class="minicart__old--price">${{ $oldPrice }}</span>
            @endif
        </div>
        <div class="minicart__text--footer d-flex align-items-center">
            <div class="quantity__box minicart__quantity">
                <button type="button" class="quantity__value decrease" aria-label="quantity value" value="Decrease Value">-</button>
                <label>
                    <input type="number" class="quantity__number" value="{{ $quantity }}" data-counter />
                </label>
                <button type="button" class="quantity__value increase" aria-label="quantity value" value="Increase Value">+</button>
            </div>
            <button class="minicart__product--remove" type="button">Remove</button>
        </div>
    </div>
</div>
