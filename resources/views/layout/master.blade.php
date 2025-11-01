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

    <!-- Fix cursor for overlay elements -->
    <style>
        body.overlay__active::before,
        .predictive__search--box_active::before,
        .mobile_menu_open::before,
        .offCanvas__minicart_active::before,
        .offcanvas__filter--sidebar_active::before {
            cursor: pointer !important;
        }

        /* Product image loading transition */
        .product__card--image {
            opacity: 1;
            transition: opacity 0.3s ease;
        }

        .product__card--image.loaded {
            opacity: 1;
        }
    </style>

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

    <!-- Product image lazy loading with placeholder -->
    <script>
        (function() {
            function loadProductImages() {
                const productImages = document.querySelectorAll('.product__card--image[data-src]');

                productImages.forEach(function(img) {
                    const actualSrc = img.getAttribute('data-src');
                    if (!actualSrc) return;

                    // Create a new image to preload
                    const preloadImg = new Image();

                    preloadImg.onload = function() {
                        // Once loaded, swap the src
                        img.src = actualSrc;
                        img.classList.add('loaded');
                    };

                    preloadImg.onerror = function() {
                        // If image fails to load, keep the placeholder
                        img.classList.add('error');
                    };

                    // Start loading the actual image
                    preloadImg.src = actualSrc;
                });
            }

            // Load images when DOM is ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', loadProductImages);
            } else {
                loadProductImages();
            }

            // Also handle dynamically added slides (e.g., Swiper)
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.addedNodes.length) {
                        loadProductImages();
                    }
                });
            });

            // Observe the document body for new nodes
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        })();
    </script>

    @stack('scripts')
</body>

</html>
