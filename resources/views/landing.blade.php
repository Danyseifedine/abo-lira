@extends('layout.master')
@section('content')
    <style>
        /*# sourceMappingURL=style.css.map */

        .hero-titles {
            color: var(--text-white-color);
        }

        @media (max-width: 768px) {
            .hero-titles {
                color: black;
            }

            .hero-description {
                color: black;
            }

            .hero-learn-more {
                color: #333333;
            }

        }

        /* For xs, sm, md (< 992px): Text outside at bottom, full width */
        @media (max-width: 991px) {
            .banner__video--inner {
                padding-right: 0 !important;
            }

            .banner__video--thumbnail {
                width: 100%;
            }

            .banner__video--thumbnail > div {
                width: 100% !important;
                max-width: 100%;
                height: auto !important;
                aspect-ratio: 817 / 602;
                display: block;
            }

            .banner__video--thumbnail img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .banner__video--section .image__width--text {
                position: relative !important;
                top: auto !important;
                transform: none !important;
                width: 100% !important;
                max-width: 100% !important;
                padding: 10px !important;
                margin-top: 0 !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
                left: auto !important;
                right: auto !important;
                z-index: 1;
            }
        }

        /* For lg (992px - 1279px): Text inside at bottom */
        @media (min-width: 992px) and (max-width: 1279px) {
            .banner__video--inner {
                padding-right: 0 !important;
            }

            .banner__video--thumbnail {
                width: 100%;
            }

            .banner__video--thumbnail > div {
                width: 100% !important;
                max-width: 100%;
                height: auto !important;
                aspect-ratio: 817 / 602;
                display: block;
            }

            .banner__video--thumbnail img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .banner__video--section .image__width--text {
                position: absolute !important;
                top: auto !important;
                bottom: -5rem !important;
                transform: none !important;
                padding: 20px;
                width: 90% !important;
                max-width: 400px !important;
                margin-top: 0 !important;
                z-index: 10;
            }

            .banner__video--section[style*="direction: rtl"] .image__width--text {
                right: auto !important;
                left: 2rem;
            }

            .banner__video--section[style*="direction: ltr"] .image__width--text {
                left: auto !important;
                right: 2rem;
            }
        }
    </style>

    <main class="main__content_wrapper">
        <!-- Start slider section -->
        <section class="hero__slider--section">
            <div class="slider__thumbnail--style5 position-relative">
                <img class="slider__thumbnail--img__style5" src="{{ asset('assets/img/abo-lira/hero.svg') }}" alt="slider-img">
                <div class="hero__content--style5 text-center">
                    <h2 class="hero__content--style5__title h1">
                        <span class="hero-titles">{{ __('landing.hero_title_1') }}</span><br>
                        <span class="text__secondary">{{ __('landing.hero_title_2') }}</span><br>
                        <span class="hero-titles">{{ __('landing.hero_title_3') }}</span>
                    </h2>

                    <!-- Enhanced Hero Content -->
                    <div class="hero__enhanced--content mt-4">
                        <p class="hero__description hero-description mb-4">
                            {{ __('landing.hero_description') }}
                        </p>

                        <!-- Call to Action Buttons -->
                        <div class="hero__cta--buttons d-flex gap-3 justify-content-center flex-wrap mb-4">
                            <a href="{{ route('shop') }}" class="hero__btn hero__btn--primary">
                                <i class="fas fa-shopping-bag me-2"></i>
                                {{ __('landing.shop_now') }}
                            </a>
                            <a href="{{ route('about') }}" class="hero__btn hero__btn--secondary hero-learn-more">
                                <i class="fas fa-info-circle me-2"></i>
                                {{ __('landing.learn_more') }}
                            </a>
                        </div>

                    </div>
                </div>
            </div>

        </section>
        <!-- End slider section -->

        <!-- Start categories section -->
        <section class="categories__section section--padding">
            <div class="container">
                <div class="section__heading border-bottom mb-30">
                    <h2 class="section__heading--maintitle">{{ __('landing.shop_by') }} <span>{{ __('landing.categories') }}</span></h2>
                </div>
                <div class="categories__inner--style3 d-flex">
                    @foreach ($categories as $category)
                        <x-category image="{{ $category->image }}"
                            link="{{ route('shop', ['category' => $category->slug]) }}" :name="$category->name"
                            :itemCount="12" />
                    @endforeach
                </div>
        </section>
        <!-- End categories section -->


        <!-- Start product section -->
        <section class="product__section section--padding pt-0">
            <div class="container">
                <div class="section__heading border-bottom mb-30">
                    <h2 class="section__heading--maintitle"><a href="{{ route('shop') }}">{{ __('landing.products_less_than_5') }}</a>
                    </h2>
                </div>
                <div class="product__section--inner pb-15 product__swiper--activation swiper">
                    <div class="swiper-wrapper">
                        @foreach ($productsLessThanPrice5 as $product)
                            <x-product-slide :slug="$product->slug" :primaryImage="$product->image" :name="$product->name" :description="$product->description" :price="$product->price"
                                :basePrice="$product->base_price" :discountPercentage="$product->discount_percentage" :category="$product->category" :quality="$product->quality" :hasMultipleVariants="$product->has_multiple_variants"
                                :is_discounted="$product->is_discounted" />
                        @endforeach
                    </div>
                    <div class="swiper__nav--btn swiper-button-next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class=" -chevron-right" style="{{ app()->getLocale() === 'ar' ? 'transform: rotate(180deg);' : '' }}">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                    <div class="swiper__nav--btn swiper-button-prev">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class=" -chevron-left" style="{{ app()->getLocale() === 'ar' ? 'transform: rotate(180deg);' : '' }}">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </div>

                    <style>
                        [dir="rtl"] .swiper__nav--btn.swiper-button-next {
                            right: auto !important;
                            left: 0 !important;
                        }

                        [dir="rtl"] .swiper__nav--btn.swiper-button-prev {
                            left: auto !important;
                            right: 0 !important;
                        }
                    </style>
                </div>
            </div>
        </section>
        <!-- End product section -->

        <!-- Start blog section -->
        <section class="blog__section section--padding">
            <div class="container">
                <div
                    class="section__heading section__heading--flex border-bottom d-flex justify-content-between align-items-end mb-30">
                    <h2 class="section__heading--maintitle">{{ __('landing.blog_article') }}</h2>
                </div>
                <div class="blog__section--inner row">
                    <div class="col-md-6 mb-4">
                        <div class="blog__card">
                            <div class="blog__card--thumbnail">
                                <span class="blog__card--thumbnail__link">
                                    <img class="blog__card--thumbnail__img"
                                        src="{{ asset('assets/img/abo-lira/blog-1.jpeg') }}" alt="blog-img">
                                </span>
                                <span class="blog__card--meta__date">20 <br> {{ __('landing.month_oct') }}</span>
                            </div>
                            <div class="blog__card--content">
                                <span class="blog__card--meta">{{ __('landing.blog_by') }}
                                    {{ __('landing.blog_author') }}</span>
                                <h3 class="blog__card--title">
                                    <span>{{ __('landing.blog_title') }}</span>
                                </h3>
                                <p class="blog__card--desc">{{ __('landing.blog_description') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="blog__card">
                            <div class="blog__card--thumbnail">
                                <span class="blog__card--thumbnail__link">
                                    <img class="blog__card--thumbnail__img"
                                        src="{{ asset('assets/img/abo-lira/blog-2.jpeg') }}" alt="blog-img">
                                </span>
                                <span class="blog__card--meta__date">24 <br> {{ __('landing.month_oct') }}</span>
                            </div>
                            <div class="blog__card--content">
                                <span class="blog__card--meta">{{ __('landing.blog_by') }}
                                    {{ __('landing.blog_author') }}</span>
                                <h3 class="blog__card--title">
                                    <span>{{ __('landing.blog_title_2') }}</span>
                                </h3>
                                <p class="blog__card--desc">{{ __('landing.blog_description_2') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End blog section -->

        <!-- Start banner video section -->
        <section style="{{ app()->getLocale() === 'ar' ? 'direction: rtl;' : 'direction: ltr;' }}"
            class="banner__video--section section--padding pt-0">
            <div class="container" style="{{ app()->getLocale() === 'ar' ? 'direction: ltr;' : 'direction: ltr;' }}">
                <div class="banner__video--inner position-relative">
                    <div class="banner__video--thumbnail position-relative">
                        <div style="position: relative; display: inline-block; width: 817px; height: 602px;">
                            <img class="border-radius-5" width="817" height="602"
                                src="{{ asset('assets/img/abo-lira/thumbnail.jpeg') }}"
                                alt="{{ __('landing.commit_image_alt', ['brand' => config('app.name')]) }}"
                                title="{{ __('landing.commit_image_title', ['brand' => config('app.name')]) }}"
                                style="display: block; width: 100%; height: 100%;" loading="lazy" decoding="async" />
                            <div
                                style="
                                position: absolute;
                                inset: 0;
                                border-radius: 8px;
                                pointer-events: none;
                                background: linear-gradient(to {{ app()->getLocale() === 'ar' ? 'left' : 'right' }}, rgba(0,0,0,0.88) 0%, rgba(0,0,0,0.36) 40%, rgba(0,0,0,0) 80%);
                            ">
                            </div>
                        </div>

                        @php
                            $ar_video_play = '';
                            if (app()->getLocale() === 'ar') {
                                $ar_video_play = 'right: 3rem;';
                            }
                        @endphp
                        <a class="banner__video--play glightbox" style="{{ $ar_video_play }}"
                            href="{{ asset('assets/img/abo-lira/vid.mp4') }}" data-gallery="video">
                            <svg width="26" height="25" viewBox="0 0 26 25" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <circle cx="13.2212" cy="12.5" r="12" stroke="currentColor" />
                                <path
                                    d="M18.9712 12.067C19.3045 12.2594 19.3045 12.7406 18.9712 12.933L10.7212 17.6962C10.3879 17.8886 9.97119 17.648 9.97119 17.2631L9.97119 7.73686C9.97119 7.35196 10.3879 7.1114 10.7212 7.30385L18.9712 12.067Z"
                                    fill="currentColor" />
                            </svg>
                            {{ __('landing.watch_video') }}
                        </a>
                    </div>
                    <div class="image__width--text"
                        style="{{ app()->getLocale() === 'ar' ? 'direction: rtl;' : 'direction: ltr;' }}">
                        <h2 class="image__width--text__title">{{ __('landing.commit_title') }}</h2>
                        <p class="image__width--text__desc">{{ __('landing.commit_description') }}</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- End banner video section -->

        <!-- Start product section -->
        <section class="product__section section--padding pt-0">
            <div class="container">
                <div class="section__heading border-bottom mb-30">
                    <h2 class="section__heading--maintitle"><a href="{{ route('shop') }}">{{ __('landing.accessories') }}</a>
                    </h2>
                </div>
                <div class="product__section--inner pb-15 product__swiper--activation swiper">
                    <div class="swiper-wrapper">
                        @foreach ($accessoriesProducts as $product)
                            <x-product-slide :slug="$product->slug" :primaryImage="$product->image" :name="$product->name" :description="$product->description" :price="$product->price"
                                :basePrice="$product->base_price" :discountPercentage="$product->discount_percentage" :category="$product->category" :quality="$product->quality"
                                :hasMultipleVariants="$product->has_multiple_variants" :is_discounted="$product->is_discounted" />
                        @endforeach
                    </div>
                    <div class="swiper__nav--btn swiper-button-next">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class=" -chevron-right" style="{{ app()->getLocale() === 'ar' ? 'transform: rotate(180deg);' : '' }}">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </div>
                    <div class="swiper__nav--btn swiper-button-prev">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class=" -chevron-left" style="{{ app()->getLocale() === 'ar' ? 'transform: rotate(180deg);' : '' }}">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </div>
                </div>
            </div>
        </section>
        <!-- End product section -->

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
                                    <span class="banner__content--subtitle text__secondary">{{ __('landing.banner_subtitle_1') }}</span>
                                    <h2 class="banner__content--title"><span class="banner__content--title__inner">{{ __('landing.banner_title_1') }}</span> {{ __('landing.banner_collection') }}</h2>
                                    <span class="banner__content--price">{{ __('landing.banner_price_1') }}</span>
                                    <span class="banner__content--btn">{{ __('landing.buy_now') }}
                                        <svg width="12" height="8" viewBox="0 0 12 8" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.8335 3.6178L8.26381 0.157332C8.21395 0.107774 8.1532 0.0681771 8.08544 0.0410843C8.01768 0.0139915 7.94441 0 7.87032 0C7.79624 0 7.72297 0.0139915 7.65521 0.0410843C7.58746 0.0681771 7.5267 0.107774 7.47684 0.157332C7.37199 0.262044 7.31393 0.39827 7.31393 0.539537C7.31393 0.680805 7.37199 0.817024 7.47684 0.921736L10.0943 3.45837H0.55625C0.405122 3.46829 0.26375 3.52959 0.160556 3.62994C0.057363 3.73029 0 3.86225 0 3.99929C0 4.13633 0.057363 4.26829 0.160556 4.36864C0.26375 4.46899 0.405122 4.53029 0.55625 4.54021H10.0927L7.47527 7.07826C7.37042 7.18298 7.31235 7.3192 7.31235 7.46047C7.31235 7.60174 7.37042 7.73796 7.47527 7.84267C7.52513 7.89223 7.58588 7.93182 7.65364 7.95892C7.7214 7.98601 7.79467 8 7.86875 8C7.94284 8 8.0161 7.98601 8.08386 7.95892C8.15162 7.93182 8.21238 7.89223 8.26223 7.84267L11.8335 4.38932C11.9406 4.28419 12 4.14649 12 4.00356C12 3.86063 11.9406 3.72293 11.8335 3.6178Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                </div>
                                <span class="banner__badge">{{ __('landing.banner_discount_1') }} <br> {{ __('landing.off') }}</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 mb-30">
                        <div class="banner__items position__relative">
                            <a class="banner__thumbnail display-block" href="shop.html"><img
                                    class="banner__thumbnail--img banner__max--height"
                                    src="{{ asset('assets/img/banner/banner2.webp') }}" alt="banner-img">
                                <div class="banner__content right">
                                    <span class="banner__badge--style2">{{ __('landing.banner_discount_2') }}</span>
                                    <h2 class="banner__content--title">{{ __('landing.banner_title_2_part1') }} <br> {{ __('landing.banner_title_2_part2') }} <span
                                            class="banner__content--title__inner"> {{ __('landing.banner_title_2_part3') }} </span></h2>
                                    <span class="banner__content--btn mt-0">{{ __('landing.buy_now') }}
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
