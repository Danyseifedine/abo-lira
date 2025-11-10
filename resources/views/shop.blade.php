@extends('layout.master')
@section('content')
<!-- Start offcanvas filter sidebar -->
<div class="offcanvas__filter--sidebar widget__area">
    <button type="button" class="offcanvas__filter--close" data-offcanvas>
        <svg class="minicart__close--icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M368 368L144 144M368 144L144 368"></path>
        </svg> <span class="offcanvas__filter--close__text">{{ __('shop.close') }}</span>
    </button>
    <div class="offcanvas__filter--sidebar__inner">
        <!-- <div class="single__widget widget__bg">
            <h2 class="widget__title h3">Categories</h2>
            <ul class="widget__categories--menu">
                <li class="widget__categories--menu__list">
                    <label class="widget__categories--menu__label d-flex align-items-center">
                        <img class="widget__categories--menu__img" src="assets/img/product/small-product/product1.webp" alt="categories-img">
                        <span class="widget__categories--menu__text">Smart Devices</span>
                        <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394">
                            <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                        </svg>
                    </label>
                    <ul class="widget__categories--sub__menu">
                        <li class="widget__categories--sub__menu--list">
                            <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product2.webp" alt="categories-img">
                                <span class="widget__categories--sub__menu--text">Discount Weekly</span>
                            </a>
                        </li>
                        <li class="widget__categories--sub__menu--list">
                            <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product3.webp" alt="categories-img">
                                <span class="widget__categories--sub__menu--text">Green dhaniya</span>
                            </a>
                        </li>
                        <li class="widget__categories--sub__menu--list">
                            <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product4.webp" alt="categories-img">
                                <span class="widget__categories--sub__menu--text">resh Nuts</span>
                            </a>
                        </li>
                        <li class="widget__categories--sub__menu--list">
                            <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product5.webp" alt="categories-img">
                                <span class="widget__categories--sub__menu--text">Millk Cream</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="widget__categories--menu__list">
                    <label class="widget__categories--menu__label d-flex align-items-center">
                        <img class="widget__categories--menu__img" src="assets/img/product/small-product/product2.webp" alt="categories-img">
                        <span class="widget__categories--menu__text">Break disc Parts</span>
                        <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394">
                            <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                        </svg>
                    </label>
                    <ul class="widget__categories--sub__menu">
                        <li class="widget__categories--sub__menu--list">
                            <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product2.webp" alt="categories-img">
                                <span class="widget__categories--sub__menu--text">Discount Weekly</span>
                            </a>
                        </li>
                        <li class="widget__categories--sub__menu--list">
                            <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product3.webp" alt="categories-img">
                                <span class="widget__categories--sub__menu--text">Green dhaniya</span>
                            </a>
                        </li>
                        <li class="widget__categories--sub__menu--list">
                            <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product4.webp" alt="categories-img">
                                <span class="widget__categories--sub__menu--text">resh Nuts</span>
                            </a>
                        </li>
                        <li class="widget__categories--sub__menu--list">
                            <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product5.webp" alt="categories-img">
                                <span class="widget__categories--sub__menu--text">Millk Cream</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="widget__categories--menu__list">
                    <label class="widget__categories--menu__label d-flex align-items-center">
                        <img class="widget__categories--menu__img" src="assets/img/product/small-product/product3.webp" alt="categories-img">
                        <span class="widget__categories--menu__text">Service Kits</span>
                        <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394">
                            <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                        </svg>
                    </label>
                    <ul class="widget__categories--sub__menu">
                        <li class="widget__categories--sub__menu--list">
                            <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product2.webp" alt="categories-img">
                                <span class="widget__categories--sub__menu--text">Discount Weekly</span>
                            </a>
                        </li>
                        <li class="widget__categories--sub__menu--list">
                            <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product3.webp" alt="categories-img">
                                <span class="widget__categories--sub__menu--text">Green dhaniya</span>
                            </a>
                        </li>
                        <li class="widget__categories--sub__menu--list">
                            <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product4.webp" alt="categories-img">
                                <span class="widget__categories--sub__menu--text">resh Nuts</span>
                            </a>
                        </li>
                        <li class="widget__categories--sub__menu--list">
                            <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product5.webp" alt="categories-img">
                                <span class="widget__categories--sub__menu--text">Millk Cream</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="widget__categories--menu__list">
                    <label class="widget__categories--menu__label d-flex align-items-center">
                        <img class="widget__categories--menu__img" src="assets/img/product/small-product/product4.webp" alt="categories-img">
                        <span class="widget__categories--menu__text">Engine Parts</span>
                        <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394">
                            <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                        </svg>
                    </label>
                    <ul class="widget__categories--sub__menu">
                        <li class="widget__categories--sub__menu--list">
                            <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product2.webp" alt="categories-img">
                                <span class="widget__categories--sub__menu--text">Discount Weekly</span>
                            </a>
                        </li>
                        <li class="widget__categories--sub__menu--list">
                            <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product3.webp" alt="categories-img">
                                <span class="widget__categories--sub__menu--text">Green dhaniya</span>
                            </a>
                        </li>
                        <li class="widget__categories--sub__menu--list">
                            <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product4.webp" alt="categories-img">
                                <span class="widget__categories--sub__menu--text">resh Nuts</span>
                            </a>
                        </li>
                        <li class="widget__categories--sub__menu--list">
                            <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product5.webp" alt="categories-img">
                                <span class="widget__categories--sub__menu--text">Millk Cream</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="widget__categories--menu__list">
                    <label class="widget__categories--menu__label d-flex align-items-center">
                        <img class="widget__categories--menu__img" src="assets/img/product/small-product/product5.webp" alt="categories-img">
                        <span class="widget__categories--menu__text">Oil & Lubricants</span>
                        <svg class="widget__categories--menu__arrowdown--icon" xmlns="http://www.w3.org/2000/svg" width="12.355" height="8.394">
                            <path d="M15.138,8.59l-3.961,3.952L7.217,8.59,6,9.807l5.178,5.178,5.178-5.178Z" transform="translate(-6 -8.59)" fill="currentColor"></path>
                        </svg>
                    </label>
                    <ul class="widget__categories--sub__menu">
                        <li class="widget__categories--sub__menu--list">
                            <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product2.webp" alt="categories-img">
                                <span class="widget__categories--sub__menu--text">Discount Weekly</span>
                            </a>
                        </li>
                        <li class="widget__categories--sub__menu--list">
                            <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product3.webp" alt="categories-img">
                                <span class="widget__categories--sub__menu--text">Green dhaniya</span>
                            </a>
                        </li>
                        <li class="widget__categories--sub__menu--list">
                            <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product4.webp" alt="categories-img">
                                <span class="widget__categories--sub__menu--text">resh Nuts</span>
                            </a>
                        </li>
                        <li class="widget__categories--sub__menu--list">
                            <a class="widget__categories--sub__menu--link d-flex align-items-center" href="shop.html">
                                <img class="widget__categories--sub__menu--img" src="assets/img/product/small-product/product5.webp" alt="categories-img">
                                <span class="widget__categories--sub__menu--text">Millk Cream</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div> -->

        <div class="single__widget price__filter widget__bg">
            <h2 class="widget__title h3">{{ __('shop.filter_by_price') }}</h2>
            <form class="price__filter--form" action="{{ route('shop') }}" method="GET">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif
                <div class="price__filter--form__inner mb-3 d-flex align-items-end gap-3 flex-wrap">
                    <div class="price__filter--group flex-grow-1 flex-shrink-0" style="min-width: 100px;">
                        <label class="price__filter--label d-block mb-2" for="Filter-Price-GTE">{{ __('shop.from') }}</label>
                        <div class="price__filter--input border rounded d-flex align-items-center">
                            <span class="price__filter--currency px-2">$</span>
                            <input class="price__filter--input__field border-0 flex-grow-1 w-100" name="price_min" id="Filter-Price-GTE" type="number" placeholder="0" min="0" step="0.01" value="{{ request('price_min') }}">
                        </div>
                    </div>
                    <!-- <div class="price__divider d-flex align-items-center pb-2">
                        <span>-</span>
                    </div> -->
                    <div class="price__filter--group flex-grow-1 flex-shrink-0" style="min-width: 100px;">
                        <label class="price__filter--label d-block mb-2" for="Filter-Price-LTE">{{ __('shop.to') }}</label>
                        <div class="price__filter--input border rounded d-flex align-items-center">
                            <span class="price__filter--currency px-2">$</span>
                            <input class="price__filter--input__field border-0 flex-grow-1 w-100" name="price_max" id="Filter-Price-LTE" type="number" min="0" step="0.01" placeholder="250.00" value="{{ request('price_max') }}">
                        </div>
                    </div>
                </div>
                <button class="primary__btn price__filter--btn" type="submit">{{ __('shop.filter') }}</button>
            </form>
        </div>
    </div>
</div>
<!-- End offcanvas filter sidebar -->

<main class="main__content_wrapper">

    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <h1 class="breadcrumb__content--title">{{ __('shop.title') }}</h1>
                        <nav aria-label="breadcrumb">
                            <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap" @if(app()->getLocale() === 'ar') dir="rtl" @endif>
                                <a href="{{ route('home') }}" class="text-decoration-none breadcrumb-link" style="font-size: 15px; line-height: 22px; color: #333; transition: color 0.3s ease;">{{ __('shop.breadcrumb_home') }}</a>
                                <span style="color: var(--secondary-color, #dc3545); font-size: 15px; line-height: 22px; user-select: none;">/</span>
                                <span class="fw-medium" style="font-size: 15px; line-height: 22px; color: #333;" aria-current="page">{{ __('shop.breadcrumb_product') }}</span>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->

    <!-- Start shop section -->
    <div class="shop__section section--padding">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-4 shop-col-width-lg-4">
                    <div class="shop__sidebar--widget widget__area d-none d-lg-block">

                        <div class="single__widget price__filter widget__bg">
                            <h2 class="widget__title h3">{{ __('shop.filter_by_price') }}</h2>
                            <form class="price__filter--form" action="{{ route('shop') }}" method="GET">
                                @if(request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif
                                @if(request('sort'))
                                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                                @endif
                                <div class="price__filter--form__inner mb-3 d-flex align-items-end gap-3 flex-wrap">
                                    <div class="price__filter--group flex-grow-1 flex-shrink-0" style="min-width: 100px;">
                                        <label class="price__filter--label d-block mb-2" for="Filter-Price-GTE2">{{ __('shop.from') }}</label>
                                        <div class="price__filter--input border rounded d-flex align-items-center">
                                            <span class="price__filter--currency px-2">$</span>
                                            <input class="price__filter--input__field border-0 flex-grow-1 w-100" name="price_min" id="Filter-Price-GTE2" type="number" placeholder="0" min="0" step="0.01" value="{{ request('price_min') }}">
                                        </div>
                                    </div>
                                    <!-- <div class="price__divider d-flex align-items-center pb-2">
                                        <span>-</span>
                                    </div> -->
                                    <div class="price__filter--group flex-grow-1 flex-shrink-0" style="min-width: 100px;">
                                        <label class="price__filter--label d-block mb-2" for="Filter-Price-LTE2">{{ __('shop.to') }}</label>
                                        <div class="price__filter--input border rounded d-flex align-items-center">
                                            <span class="price__filter--currency px-2">$</span>
                                            <input class="price__filter--input__field border-0 flex-grow-1 w-100" name="price_max" id="Filter-Price-LTE2" type="number" min="0" step="0.01" placeholder="250.00" value="{{ request('price_max') }}">
                                        </div>
                                    </div>
                                </div>
                                <button class="primary__btn price__filter--btn" type="submit">{{ __('shop.filter') }}</button>
                            </form>
                        </div>


                    </div>
                </div>
                <div class="col-xl-9 col-lg-8 shop-col-width-lg-8">
                    <div class="shop__right--sidebar">
                        <!-- Start categories section -->
                        <section class="categories__section mb-30">
                            <div class="container">
                                <div class="section__heading border-bottom mb-30">
                                    <h2 class="section__heading--maintitle">{{ __('shop.shop_by_categories') }}</h2>
                                </div>
                                <div class="categories__inner--style3 d-flex" style="flex-wrap: nowrap; overflow-x: auto;">
                                    @foreach($categories as $category)
                                        <x-category
                                            :image="$category->image"
                                            :link="route('shop', ['category' => $category->id])"
                                            :name="$category->name"
                                            :selectedCategory="$activeCategory?->id == $category->id"
                                            :itemCount="$category->products_count" />
                                    @endforeach
                                </div>
                        </section>
                        <!-- End categories section -->
                        <div class="shop__product--wrapper">
                            <div class="shop__header d-flex align-items-center justify-content-between mb-30">
                                <!-- Sort select input aligned left, view modes aligned right -->
                                <div class="d-flex align-items-center justify-content-center justify-content-sm-start flex-grow-1">
                                    <div class="product__view--mode__list product__short--by d-flex gap-2 align-items-center">
                                        <div class="select shop__header--select">
                                            <select class="product__view--select" id="sort-select" onchange="updateSort(this.value)">
                                                <option value="latest" {{ (request('sort', 'latest') == 'latest') ? 'selected' : '' }}>{{ __('shop.sort_latest') }}</option>
                                                <option value="popularity" {{ (request('sort') == 'popularity') ? 'selected' : '' }}>{{ __('shop.sort_popularity') }}</option>
                                                <option value="newness" {{ (request('sort') == 'newness') ? 'selected' : '' }}>{{ __('shop.sort_newness') }}</option>
                                                <option value="rating" {{ (request('sort') == 'rating') ? 'selected' : '' }}>{{ __('shop.sort_rating') }}</option>
                                                <option value="price_low" {{ (request('sort') == 'price_low') ? 'selected' : '' }}>{{ __('shop.sort_price_low') }}</option>
                                                <option value="price_high" {{ (request('sort') == 'price_high') ? 'selected' : '' }}>{{ __('shop.sort_price_high') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <button class="widget__filter--btn d-flex d-lg-none align-items-center me-3" data-offcanvas>
                                        <svg class="widget__filter--btn__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28" d="M368 128h80M64 128h240M368 384h80M64 384h240M208 256h240M64 256h80" />
                                            <circle cx="336" cy="128" r="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28" />
                                            <circle cx="176" cy="256" r="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28" />
                                            <circle cx="336" cy="384" r="28" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="28" />
                                        </svg>
                                        <span class="widget__filter--btn__text">{{ __('shop.filter') }}</span>
                                    </button>
                                </div>
                            </div>
                            <div class="tab_content">
                                <div id="product_grid" class="tab_pane active show">
                                    <div class="product__section--inner">
                                        <div class="row mb--n30">
                                            @forelse($products as $product)
                                                <div class="col-lg-4 col-md-6 col-sm-6 mb-30">
                                                    <x-product-slide
                                                        :slug="$product->slug"
                                                        :primaryImage="$product->image"
                                                        :name="$product->name"
                                                        :description="$product->description"
                                                        :category="$product->category"
                                                        :quality="$product->quality"
                                                        :hasMultipleVariants="$product->has_multiple_variants"
                                                        :is_discounted="$product->is_discounted"
                                                        :basePrice="number_format($product->base_price, 2)"
                                                        :price="number_format($product->price, 2)"
                                                        :oldPrice="$product->discount_percentage > 0 ? number_format($product->base_price, 2) : null"
                                                        :discountPercentage="$product->discount_percentage > 0 ? round($product->discount_percentage) : null" />
                                                </div>
                                            @empty
                                                <div class="col-12">
                                                    <p class="text-center">{{ __('shop.no_products') }}</p>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($products->hasPages())
                                <x-pagination :paginator="$products" />
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End shop section -->

</main>

@endsection

@push('scripts')
<script>
    function updateSort(value) {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', value);
        url.searchParams.set('page', '1'); // Reset to first page when sorting
        window.location.href = url.toString();
    }
</script>
@endpush