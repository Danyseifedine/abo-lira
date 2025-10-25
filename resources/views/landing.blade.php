@extends('layout.master')
@section('content')
    <main class="main__content_wrapper">
        <!-- Start slider section -->
        <section class="hero__slider--section">
            <div class="slider__thumbnail--style5 position-relative">
                <img class="slider__thumbnail--img__style5" src="{{ asset('assets/img/slider/home5-slider-thumb.webp') }}"
                    alt="slider-img">
                <div class="hero__content--style5 text-center">
                    <h2 class="hero__content--style5__title h1">Comes Width The <br> <span class="text__secondary">Ultimate
                            Protection</span></h2>
                </div>
            </div>

        </section>
        <!-- End slider section -->

        <!-- Start categories section -->
        <section class="categories__section section--padding">
            <div class="container">
                <div class="section__heading border-bottom mb-30">
                    <h2 class="section__heading--maintitle">Shop by <span>Categories</span></h2>
                </div>
                <div class="categories__inner--style3 d-flex">
                    @foreach ($categories as $category)
                        <x-category image="assets/img/categories/categories-product1.webp"
                            link="{{ route('shop', ['category' => $category->slug]) }}" :name="$category->name"
                            :itemCount="12" />
                    @endforeach
                </div>
        </section>
        <!-- End categories section -->

        <!-- Start product section -->
        <section class="product__section section--padding  pt-0">
            <div class="container">
                <div class="section__heading border-bottom mb-30">
                    <h2 class="section__heading--maintitle">Pouplar <span>Products</span></h2>
                </div>
                <div class="product__section--inner pb-15 product__swiper--activation swiper">
                    <div class="swiper-wrapper">
                        <x-product-slide primaryImage="assets/img/product/main-product/product5.webp" name="1"
                            currentPrice="239.52" oldPrice="362.00" discount="14" />

                    </div>
                    <div class="swiper__nav--btn swiper-button-next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class=" -chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                    <div class="swiper__nav--btn swiper-button-prev">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class=" -chevron-left">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </div>
                </div>
            </div>
        </section>
        <!-- End product section -->

        <!-- Start product section -->
        <section class="product__section section--padding pt-0">
            <div class="container">
                <div class="section__heading border-bottom mb-30">
                    <h2 class="section__heading--maintitle">Latest <span>Products</span></h2>
                </div>
                <div class="product__section--inner pb-15 product__swiper--activation swiper">
                    <div class="swiper-wrapper">
                        <x-product-slide primaryImage="assets/img/product/main-product/product5.webp" name="1"
                            currentPrice="239.52" oldPrice="362.00" discount="14" />
                    </div>
                    <div class="swiper__nav--btn swiper-button-next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class=" -chevron-right">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                    <div class="swiper__nav--btn swiper-button-prev">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class=" -chevron-left">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </div>
                </div>
            </div>
        </section>
        <!-- End product section -->

        <!-- Start product section -->
        <section class="product__section deal__section--bg section--padding ">
            <div class="container">
                <div class="section__heading  border-bottom mb-30">
                    <h2 class="section__heading--maintitle">Deal Of <span>The Day</span></h2>
                </div>
                <div class="product__section--inner">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="single__product--wrapper">
                                <div class="single__product--topbar d-flex align-items-center">
                                    <div class="single__product--preview single__product--thumbnail__preview swiper">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <div class="single__product--thumbnail">
                                                    <a class="single__product--thumbnail__link display-block"
                                                        href="product-details.html">
                                                        <img class="single__product--thumbnail__img"
                                                            src="{{ asset('assets/img/product/big-product/product1.webp') }}"
                                                            alt="product-img">
                                                    </a>
                                                    <span class="product__badge style__left">-14%</span>
                                                    <span class="product__badge--new">New</span>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="single__product--thumbnail">
                                                    <a class="single__product--thumbnail__link display-block"
                                                        href="product-details.html">
                                                        <img class="single__product--thumbnail__img"
                                                            src="{{ asset('assets/img/product/big-product/product2.webp') }}"
                                                            alt="product-img">
                                                    </a>
                                                    <span class="product__badge style__left">-14%</span>
                                                    <span class="product__badge--new">New</span>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="single__product--thumbnail">
                                                    <a class="single__product--thumbnail__link display-block"
                                                        href="product-details.html">
                                                        <img class="single__product--thumbnail__img"
                                                            src="{{ asset('assets/img/product/big-product/product3.webp') }}"
                                                            alt="product-img">
                                                    </a>
                                                    <span class="product__badge style__left">-14%</span>
                                                    <span class="product__badge--new">New</span>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="single__product--thumbnail">
                                                    <a class="single__product--thumbnail__link display-block"
                                                        href="product-details.html">
                                                        <img class="single__product--thumbnail__img"
                                                            src="{{ asset('assets/img/product/big-product/product4.webp') }}"
                                                            alt="product-img">
                                                    </a>
                                                    <span class="product__badge style__left">-14%</span>
                                                    <span class="product__badge--new">New</span>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="single__product--thumbnail">
                                                    <a class="single__product--thumbnail__link display-block"
                                                        href="product-details.html">
                                                        <img class="single__product--thumbnail__img"
                                                            src="{{ asset('assets/img/product/big-product/product5.webp') }}"
                                                            alt="product-img">
                                                    </a>
                                                    <span class="product__badge style__left">-14%</span>
                                                    <span class="product__badge--new">New</span>
                                                </div>
                                            </div>
                                            <div class="swiper-slide">
                                                <div class="single__product--thumbnail">
                                                    <a class="single__product--thumbnail__link display-block"
                                                        href="product-details.html">
                                                        <img class="single__product--thumbnail__img"
                                                            src="{{ asset('assets/img/product/big-product/product6.webp') }}"
                                                            alt="product-img">
                                                    </a>
                                                    <span class="product__badge style__left">-14%</span>
                                                    <span class="product__badge--new">New</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single__product--content">

                                        <h3 class="single__product--title h2"><a href="product-details.html">Brendy Bluest
                                                Headphone </a></h3>
                                        <div class="product__card--price">
                                            <span class="current__price">$239.52</span>
                                            <span class="old__price"> $362.00</span>
                                        </div>
                                        <div class="product__sold">
                                            <span class="product__sold--text">Available: <span
                                                    class="product__sold--text__number">334</span></span>
                                            <span class="product__sold--text">Units Sold: <span
                                                    class="product__sold--text__number">1</span></span>
                                        </div>
                                        <div class="single__product--countdown d-flex"
                                            data-countdown="Sep 30, 2023 00:00:00"></div>

                                        <ul class="single__product--action d-flex align-items-center">
                                            <li class="single__product--action__list">
                                                <a class="single__product--cart__btn" href="cart.html">
                                                    Add to cart
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End product section -->

        <!-- Start blog section -->
        <section class="blog__section section--padding">
            <div class="container">
                <div
                    class="section__heading section__heading--flex border-bottom d-flex justify-content-between align-items-end mb-30">
                    <h2 class="section__heading--maintitle">Blog & article</h2>
                    <a class="view__all--link" href="blog.html">View all Blog</a>
                </div>
                <div class="blog__section--inner row">
                    <div class="col-md-6 mb-4">
                        <div class="blog__card">
                            <div class="blog__card--thumbnail">
                                <a class="blog__card--thumbnail__link" href="blog-details.html">
                                    <img class="blog__card--thumbnail__img"
                                        src="{{ asset('assets/img/blog/blog1.webp') }}" alt="blog-img">
                                </a>
                                <span class="blog__card--meta__date">20 <br> Oct</span>
                            </div>
                            <div class="blog__card--content">
                                <span class="blog__card--meta">By: Rasalina</span>
                                <h3 class="blog__card--title"><a href="blog-details.html">Beauty Skin Care Product In
                                        Stock</a></h3>
                                <p class="blog__card--desc">Namkand sodales vel online best prices when
                                    an unknown printer took a galley of </p>
                                <div class="blog__card--footer d-flex justify-content-between align-items-center">
                                    <a class="blog__card--btn__link" href="blog-details.html">Read more
                                        <svg width="12" height="8" viewBox="0 0 12 8" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.8335 3.6178L8.26381 0.157332C8.21395 0.107774 8.1532 0.0681771 8.08544 0.0410843C8.01768 0.0139915 7.94441 0 7.87032 0C7.79624 0 7.72297 0.0139915 7.65521 0.0410843C7.58746 0.0681771 7.5267 0.107774 7.47684 0.157332C7.37199 0.262044 7.31393 0.39827 7.31393 0.539537C7.31393 0.680805 7.37199 0.817024 7.47684 0.921736L10.0943 3.45837H0.55625C0.405122 3.46829 0.26375 3.52959 0.160556 3.62994C0.057363 3.73029 0 3.86225 0 3.99929C0 4.13633 0.057363 4.26829 0.160556 4.36864C0.26375 4.46899 0.405122 4.53029 0.55625 4.54021H10.0927L7.47527 7.07826C7.37042 7.18298 7.31235 7.3192 7.31235 7.46047C7.31235 7.60174 7.37042 7.73796 7.47527 7.84267C7.52513 7.89223 7.58588 7.93182 7.65364 7.95892C7.7214 7.98601 7.79467 8 7.86875 8C7.94284 8 8.0161 7.98601 8.08386 7.95892C8.15162 7.93182 8.21238 7.89223 8.26223 7.84267L11.8335 4.38932C11.9406 4.28419 12 4.14649 12 4.00356C12 3.86063 11.9406 3.72293 11.8335 3.6178Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="blog__card">
                            <div class="blog__card--thumbnail">
                                <a class="blog__card--thumbnail__link" href="blog-details.html">
                                    <img class="blog__card--thumbnail__img"
                                        src="{{ asset('assets/img/blog/blog2.webp') }}" alt="blog-img">
                                </a>
                                <span class="blog__card--meta__date">24 <br> Oct</span>
                            </div>
                            <div class="blog__card--content">
                                <span class="blog__card--meta">By: Rasalina</span>
                                <h3 class="blog__card--title"><a href="blog-details.html">Lorem ipsum dolor sit thre
                                        elit.</a></h3>
                                <p class="blog__card--desc">Namkand sodales vel online best prices when
                                    an unknown printer took a galley of </p>
                                <div class="blog__card--footer d-flex justify-content-between align-items-center">
                                    <a class="blog__card--btn__link" href="blog-details.html">Read more
                                        <svg width="12" height="8" viewBox="0 0 12 8" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.8335 3.6178L8.26381 0.157332C8.21395 0.107774 8.1532 0.0681771 8.08544 0.0410843C8.01768 0.0139915 7.94441 0 7.87032 0C7.79624 0 7.72297 0.0139915 7.65521 0.0410843C7.58746 0.0681771 7.5267 0.107774 7.47684 0.157332C7.37199 0.262044 7.31393 0.39827 7.31393 0.539537C7.31393 0.680805 7.37199 0.817024 7.47684 0.921736L10.0943 3.45837H0.55625C0.405122 3.46829 0.26375 3.52959 0.160556 3.62994C0.057363 3.73029 0 3.86225 0 3.99929C0 4.13633 0.057363 4.26829 0.160556 4.36864C0.26375 4.46899 0.405122 4.53029 0.55625 4.54021H10.0927L7.47527 7.07826C7.37042 7.18298 7.31235 7.3192 7.31235 7.46047C7.31235 7.60174 7.37042 7.73796 7.47527 7.84267C7.52513 7.89223 7.58588 7.93182 7.65364 7.95892C7.7214 7.98601 7.79467 8 7.86875 8C7.94284 8 8.0161 7.98601 8.08386 7.95892C8.15162 7.93182 8.21238 7.89223 8.26223 7.84267L11.8335 4.38932C11.9406 4.28419 12 4.14649 12 4.00356C12 3.86063 11.9406 3.72293 11.8335 3.6178Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End blog section -->

        <!-- Start banner video section -->
        <section class="banner__video--section section--padding pt-0">
            <div class="container">
                <div class="banner__video--inner position-relative">
                    <div class="banner__video--thumbnail position-relative">
                        <img class="border-radius-5" src="assets/img/banner/banner14.webp" alt="banner-img">
                        <a class="banner__video--play glightbox" href="https://vimeo.com/115041822" data-gallery="video">
                            <svg width="26" height="25" viewBox="0 0 26 25" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="13.2212" cy="12.5" r="12" stroke="currentColor" />
                                <path
                                    d="M18.9712 12.067C19.3045 12.2594 19.3045 12.7406 18.9712 12.933L10.7212 17.6962C10.3879 17.8886 9.97119 17.648 9.97119 17.2631L9.97119 7.73686C9.97119 7.35196 10.3879 7.1114 10.7212 7.30385L18.9712 12.067Z"
                                    fill="currentColor" />
                            </svg>
                            WATCH THE VIDEO</a>
                    </div>
                    <div class="image__width--text">
                        <h2 class="image__width--text__title">We commit to provide quality & safe.</h2>
                        <p class="image__width--text__desc">Born out of a shared love of good design & quality products, we
                            create considered solutions fit for the modern lifestyle. Always driven by passion, we work to
                            empower others to live the same.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- End banner video section -->

        <!-- Start banner section -->
        <section class="banner__section section--padding pt-0">
            <div class="container">
                <div class="row  mb--n30">
                    <div class="col-lg-6 col-md-6 mb-30">
                        <div class="banner__items position__relative">
                            <a class="banner__thumbnail display-block" href="shop.html"><img
                                    class="banner__thumbnail--img banner__max--height"
                                    src="{{ asset('assets/img/banner/banner1.webp') }}" alt="banner-img">
                                <div class="banner__content">
                                    <span class="banner__content--subtitle text__secondary">Toyota Combo</span>
                                    <h2 class="banner__content--title"><span class="banner__content--title__inner">CAR
                                            PARTS</span> COLLECTION</h2>
                                    <span class="banner__content--price">$22.99</span>
                                    <span class="banner__content--btn">Buy now
                                        <svg width="12" height="8" viewBox="0 0 12 8" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.8335 3.6178L8.26381 0.157332C8.21395 0.107774 8.1532 0.0681771 8.08544 0.0410843C8.01768 0.0139915 7.94441 0 7.87032 0C7.79624 0 7.72297 0.0139915 7.65521 0.0410843C7.58746 0.0681771 7.5267 0.107774 7.47684 0.157332C7.37199 0.262044 7.31393 0.39827 7.31393 0.539537C7.31393 0.680805 7.37199 0.817024 7.47684 0.921736L10.0943 3.45837H0.55625C0.405122 3.46829 0.26375 3.52959 0.160556 3.62994C0.057363 3.73029 0 3.86225 0 3.99929C0 4.13633 0.057363 4.26829 0.160556 4.36864C0.26375 4.46899 0.405122 4.53029 0.55625 4.54021H10.0927L7.47527 7.07826C7.37042 7.18298 7.31235 7.3192 7.31235 7.46047C7.31235 7.60174 7.37042 7.73796 7.47527 7.84267C7.52513 7.89223 7.58588 7.93182 7.65364 7.95892C7.7214 7.98601 7.79467 8 7.86875 8C7.94284 8 8.0161 7.98601 8.08386 7.95892C8.15162 7.93182 8.21238 7.89223 8.26223 7.84267L11.8335 4.38932C11.9406 4.28419 12 4.14649 12 4.00356C12 3.86063 11.9406 3.72293 11.8335 3.6178Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                </div>
                                <span class="banner__badge">25% <br> off</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 mb-30">
                        <div class="banner__items position__relative">
                            <a class="banner__thumbnail display-block" href="shop.html"><img
                                    class="banner__thumbnail--img banner__max--height"
                                    src="{{ asset('assets/img/banner/banner2.webp') }}" alt="banner-img">
                                <div class="banner__content right">
                                    <span class="banner__badge--style2">20% Off</span>
                                    <h2 class="banner__content--title">BODY PARTS <br> FOR ANY <span
                                            class="banner__content--title__inner"> VEHICLE </span></h2>
                                    <span class="banner__content--btn mt-0">Buy now
                                        <svg width="12" height="8" viewBox="0 0 12 8" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.8335 3.6178L8.26381 0.157332C8.21395 0.107774 8.1532 0.0681771 8.08544 0.0410843C8.01768 0.0139915 7.94441 0 7.87032 0C7.79624 0 7.72297 0.0139915 7.65521 0.0410843C7.58746 0.0681771 7.5267 0.107774 7.47684 0.157332C7.37199 0.262044 7.31393 0.39827 7.31393 0.539537C7.31393 0.680805 7.37199 0.817024 7.47684 0.921736L10.0943 3.45837H0.55625C0.405122 3.46829 0.26375 3.52959 0.160556 3.62994C0.057363 3.73029 0 3.86225 0 3.99929C0 4.13633 0.057363 4.26829 0.160556 4.36864C0.26375 4.46899 0.405122 4.53029 0.55625 4.54021H10.0927L7.47527 7.07826C7.37042 7.18298 7.31235 7.3192 7.31235 7.46047C7.31235 7.60174 7.37042 7.73796 7.47527 7.84267C7.52513 7.89223 7.58588 7.93182 7.65364 7.95892C7.7214 7.98601 7.79467 8 7.86875 8C7.94284 8 8.0161 7.98601 8.08386 7.95892C8.15162 7.93182 8.21238 7.89223 8.26223 7.84267L11.8335 4.38932C11.9406 4.28419 12 4.14649 12 4.00356C12 3.86063 11.9406 3.72293 11.8335 3.6178Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End banner section -->
    </main>
@endsection
