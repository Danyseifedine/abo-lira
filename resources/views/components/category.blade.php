@props([
    'image' => '',
    'link' => '#',
    'name' => 'Category',
    'itemCount' => 0,
    'selectedCategory' => false,
    'isShopCategory' => false,
])

@php
    $itemsText = __('shop.items');
    $categoryTitle = $name . ($itemCount > 0 ? ' - ' . $itemCount . ' ' . $itemsText : '');
    $imageAlt = $name . ' category' . (config('app.name') ? ' - ' . config('app.name') : '');
@endphp

<div class="categories__card--style3 text-center {{ $selectedCategory ? 'active-category' : '' }}" style="{{ $isShopCategory ? 'min-width: 180px; max-width: 180px;' : '' }}" 
   itemscope itemtype="https://schema.org/Category"
>
    <a class="categories__card--link" href="{{ $link }}" title="{{ $categoryTitle }}"
        aria-label="{{ $categoryTitle }}">
        <div class="categories__thumbnail">
            <img class="categories__thumbnail--img" width="70" height="70" src="{{ $image }}"
                alt="{{ $imageAlt }}" title="{{ $name }}" itemprop="image" loading="lazy"
                decoding="async" />
        </div>
        <div class="categories__content style3">
            <h2 class="categories__content--title {{ $selectedCategory ? 'active-category-title' : '' }}" itemprop="name">{{ $name }}</h2>
            @if ($isShopCategory && $itemCount > 0)
                <span class="categories__content--subtitle" itemprop="description">({{ $itemCount }} {{ __('shop.items') }})</span>
            @endif
        </div>
    </a>
</div>

<style>
    .active-category {
        border: 1px solid #dc3545;
    }
    .active-category-title {
        color: #dc3545;
    }
</style>
