<!doctype html>
<html dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    @class(['dark' => ($appearance ?? 'system') == 'dark'])>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- SEO Component --}}
    <x-seo :title="get_seo_data('title')" :description="get_seo_data('description')" :keywords="get_seo_data('keywords')" :image="get_seo_data('image')" :type="get_seo_data('type', 'website')" :price="get_seo_data('price')"
        :currency="get_seo_data('currency')" :availability="get_seo_data('availability')" :brand="get_seo_data('brand')" :rating="get_seo_data('rating')" :reviewCount="get_seo_data('reviewCount')" :breadcrumbs="get_seo_data('breadcrumbs')"
        :noindex="get_seo_data('noindex', false)" />

    <!-- ======= All CSS Plugins here ======== -->
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/glightbox.min.css') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500&display=swap"
        rel="stylesheet">

    <!-- Plugin css -->
    <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css') }}">
    
    <!-- Custom Style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <!-- Product Images CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/product-images.css') }}">

    @include('layout.common.loading')

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
    <script src="{{ asset('assets/js/vendor/popper.js') }}" defer="defer"></script>
    <script src="{{ asset('assets/js/vendor/bootstrap.min.js') }}" defer="defer"></script>
    <script src="{{ asset('assets/js/plugins/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/glightbox.min.js') }}"></script>

    <!-- Customscript js -->
    <script src="{{ asset('assets/js/_script.js') }}"></script>

    <!-- Product Image Loader -->
    <script src="{{ asset('assets/js/product-image-loader.js') }}" defer></script>

    @stack('scripts')
</body>

</html>
