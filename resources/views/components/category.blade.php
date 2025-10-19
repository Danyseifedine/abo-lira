@props([
    'image' => '',
    'link' => '#',
    'name' => 'Category',
    'itemCount' => 0
])

    <div class="categories__card--style3 text-center">
        <a class="categories__card--link" href="{{ $link }}">
            <div class="categories__thumbnail">
                <img class="categories__thumbnail--img" src="{{ asset($image) }}" alt="{{ $name }}">
            </div>
            <div class="categories__content style3">
                <h2 class="categories__content--title">{{ $name }}</h2>
                <span class="categories__content--subtitle">({{ $itemCount }} Items)</span>
            </div>
        </a>
    </div>
