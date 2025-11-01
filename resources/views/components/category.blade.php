@props([
    'image' => '',
    'link' => '#',
    'name' => 'Category',
    'itemCount' => 0,
])

@php
    $categoryTitle = $name . ($itemCount > 0 ? ' - ' . $itemCount . ' Items' : '');
    $imageAlt = $name . ' category' . (config('app.name') ? ' - ' . config('app.name') : '');
@endphp

<div class="categories__card--style3 text-center" itemscope itemtype="https://schema.org/Category">
    <a class="categories__card--link" href="{{ $link }}" title="{{ $categoryTitle }}"
        aria-label="{{ $categoryTitle }}">
        <div class="categories__thumbnail">
            <img class="categories__thumbnail--img" width="70" height="70" src="{{ $image }}"
                alt="{{ $imageAlt }}" title="{{ $name }}" itemprop="image" loading="lazy"
                decoding="async" />
        </div>
        <div class="categories__content style3">
            <h2 class="categories__content--title" itemprop="name">{{ $name }}</h2>
            <span class="categories__content--subtitle" itemprop="description">({{ $itemCount }} Items)</span>
        </div>
    </a>
</div>
