<!doctype html>
<html dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    @class(['dark' => ($appearance ?? 'system') == 'dark'])>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">
    <meta name="shop-url" content="{{ route('shop') }}">

    {{-- Preconnect to external domains for faster loading --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- SEO Component --}}
    <x-seo :title="get_seo_data('title')" :description="get_seo_data('description')" :keywords="get_seo_data('keywords')" :image="get_seo_data('image')" :type="get_seo_data('type', 'website')" :price="get_seo_data('price')"
        :currency="get_seo_data('currency')" :availability="get_seo_data('availability')" :brand="get_seo_data('brand')" :rating="get_seo_data('rating')" :reviewCount="get_seo_data('reviewCount')" :breadcrumbs="get_seo_data('breadcrumbs')"
        :noindex="get_seo_data('noindex', false)" />

    {{-- Preload LCP image if on landing page --}}
    @if (request()->routeIs('home'))
        <link rel="preload" as="image" href="{{ asset('assets/img/abo-lira/hero.svg') }}" fetchpriority="high">
    @endif

    <!-- ======= All CSS Plugins here ======== -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/swiper-bundle.min.css') }}" media="print"
        onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="{{ asset('assets/css/plugins/swiper-bundle.min.css') }}">
    </noscript>
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/glightbox.min.css') }}" media="print"
        onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="{{ asset('assets/css/plugins/glightbox.min.css') }}">
    </noscript>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500&display=swap"
        rel="stylesheet">

    <!-- Plugin css -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css') }}">

    <!-- Custom Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Product Images CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/product-images.css') }}" media="print"
        onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="{{ asset('assets/css/product-images.css') }}">
    </noscript>

    @include('layout.common.loading')

    <style>
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Arabic (RTL) specific styles */

        /* For the header (used in the landing and in the shop pages) */
        [dir="rtl"] .section__heading::before {
            left: auto !important;
            right: 0 !important;
        }

        [dir="rtl"] .section__heading::after {
            left: auto !important;
            right: 7px !important;
        }

        [dir="rtl"] .section__heading--maintitle {
            padding-left: 0 !important;
            padding-right: 3.4rem !important;
        }

        [dir="rtl"] .product__variant--list.quantity {
            gap: 1.5rem !important;
        }

        [dir="rtl"] .variant__color {
            gap: 1rem !important;
        }

        [dir="rtl"] .variant__size {
            gap: 1rem !important;
        }

        [dir="rtl"] .quantity__value {
            border-radius: 3px !important;
        }

        @media (max-width: 767px) {
            [dir="rtl"] .product__variant--list.quantity {
                gap: 1rem !important;
            }

            [dir="rtl"] .variant__color {
                gap: 0.75rem !important;
            }

            [dir="rtl"] .variant__size {
                gap: 0.75rem !important;
            }
        }
    </style>

    @stack('styles')
</head>

<body>


    @include('layout.common.navbar')

    <main>
        @yield('content')
    </main>

    @include('layout.common.footer')

    @include('layout.common.quickView')

    <!-- All Script JS Plugins here  -->
    <script src="{{ asset('assets/js/vendor/popper.js') }}" defer></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/plugins/swiper-bundle.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/plugins/glightbox.min.js') }}" defer></script>

    <!-- Customscript js -->
    <script src="{{ asset('assets/js/_script.js') }}" defer></script>

    <!-- Product Image Loader -->
    <script src="{{ asset('assets/js/product-image-loader.js') }}" defer></script>

    <!-- Cart Handler -->
    <script src="{{ asset('assets/js/cart.js') }}" defer></script>

    <!-- Search -->
    <script src="{{ asset('assets/js/search.js') }}" defer></script>

    @stack('scripts')
</body>

</html>
