@extends('layout.master')

@section('content')

<main class="main__content_wrapper">

    <!-- Start breadcrumb section -->
    <section class="breadcrumb__section breadcrumb__bg">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <div class="breadcrumb__content text-center">
                        <nav aria-label="breadcrumb">
                            <div class="d-flex align-items-center justify-content-center gap-2 flex-wrap" @if(app()->getLocale() === 'ar') dir="rtl" @endif>
                                <a href="{{ route('home') }}" class="text-decoration-none breadcrumb-link" style="font-size: 15px; line-height: 22px; color: #333; transition: color 0.3s ease;">
                                    {{ __('detail.home') }}
                                </a>
                                <span style="color: var(--secondary-color, #dc3545); font-size: 15px; line-height: 22px; user-select: none;">/</span>
                                <span class="fw-medium" style="font-size: 15px; line-height: 22px; color: #333;" aria-current="page">{{ __('detail.product') }}</span>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End breadcrumb section -->

    <!-- Start product details section -->
    <section class="product__details--section section--padding">
        <div class="container">
            <div class="row row-cols-1 row-cols-md-2 g-0 g-md-3">
                <div class="col mb-3 mb-md-0">
                    <div class="product__details--media">
                        <div class="single__product--preview  swiper">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="product__media--preview__items" style="width: 100%; height: 350px; min-height: 300px; background-color: #f5f5f5; border-radius: 25px; position: relative;">
                                        @if($product->image)
                                        <a
                                            class="product__media--preview__items--link glightbox product-variant-image-link variant-image-wrapper"
                                            data-gallery="product-variant-gallery-{{ $product->id }}"
                                            data-variant-id="{{ $product->id }}"
                                            href="{{ $product->image }}"
                                            style="width: 100%; height: 100%; position: absolute; top: 0; left: 0; transition: opacity 0.3s ease-in-out;">
                                            <img
                                                class="product__media--preview__items--img product-variant-image"
                                                src="{{ $product->image }}"
                                                alt="{{ __('detail.product_media_img') }}"
                                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 3px;">
                                        </a>
                                        <div class="product__media--view__icon variant-zoom-wrapper" data-variant-id="{{ $product->id }}" style="position: absolute; top: 10px; left: 10px; opacity: 1; transition: opacity 0.3s ease-in-out; pointer-events: auto;">
                                            <a
                                                class="product__media--view__icon--link glightbox product-variant-zoom-link"
                                                href="{{ $product->image }}"
                                                data-gallery="product-media-zoom">
                                                <svg class="product__items--action__btn--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="22.443" viewBox="0 0 512 512">
                                                    <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path>
                                                </svg>
                                                <span class="visually-hidden">{{ __('detail.product_view') }}</span>
                                            </a>
                                        </div>
                                        @else
                                        @foreach($product->variants as $idx => $variant)
                                        @if($variant->image)
                                        <a
                                            class="product__media--preview__items--link glightbox product-variant-image-link variant-image-wrapper"
                                            data-gallery="product-variant-gallery-{{ $product->id }}"
                                            data-variant-id="{{ $variant->id }}"
                                            href="{{ $variant->image }}"
                                            style="width: 100%; height: 100%; position: absolute; top: 0; left: 0; opacity: {{ $idx === 0 ? '1' : '0' }}; transition: opacity 0.3s ease-in-out; {{ $idx !== 0 ? 'pointer-events: none;' : '' }}">
                                            <img
                                                class="product__media--preview__items--img product-variant-image"
                                                src="{{ $variant->image }}"
                                                alt="{{ __('detail.product_media_img') }}"
                                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 3px;">
                                        </a>
                                        <div class="product__media--view__icon variant-zoom-wrapper" data-variant-id="{{ $variant->id }}" style="position: absolute; top: 10px; left: 10px; opacity: {{ $idx === 0 ? '1' : '0' }}; transition: opacity 0.3s ease-in-out; {{ $idx !== 0 ? 'pointer-events: none;' : '' }}">
                                            <a
                                                class="product__media--view__icon--link glightbox product-variant-zoom-link"
                                                href="{{ $variant->image }}"
                                                data-gallery="product-media-zoom">
                                                <svg class="product__items--action__btn--svg" xmlns="http://www.w3.org/2000/svg" width="22.51" height="22.443" viewBox="0 0 512 512">
                                                    <path d="M221.09 64a157.09 157.09 0 10157.09 157.09A157.1 157.1 0 00221.09 64z" fill="none" stroke="currentColor" stroke-miterlimit="10" stroke-width="32"></path>
                                                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M338.29 338.29L448 448"></path>
                                                </svg>
                                                <span class="visually-hidden">{{ __('detail.product_view') }}</span>
                                            </a>
                                        </div>
                                        @else
                                        <div class="d-flex align-items-center justify-content-center w-100 h-100">
                                            <span>{{ __('detail.no_image') }}</span>
                                        </div>
                                        @endif
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="product__details--info w-100">
                        <form id="add-to-cart-form" action="{{ route('add-to-cart') }}" method="post">
                            @csrf
                            <input type="hidden" name="slug" value="{{ $product->slug }}">

                            @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show mb-15" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mb-15" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mb-15" role="alert">
                                <strong>{{ __('detail.validation_error') }}</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @endif

                            <h2 class="product__details--info__title mb-15">{{ $product->name }}</h2>
                            @if($product->description)
                            <p class="product__details--info__desc mb-15">
                                {{ $product->description }}
                            </p>
                            @endif

                            @if($product->variants->count() > 0)
                            <div class="product__details--info__price mb-12">
                                @foreach($product->variants as $variant)
                                <span class="current__price product-variant-price" data-variant-id="{{ $variant->id }}" style="display: {{ $loop->first ? 'inline' : 'none' }};">${{ number_format($variant->price, 2) }}</span>
                                @if(isset($variant->original_price) && $variant->original_price > $variant->price)
                                <span class="old__price product-variant-original-price" data-variant-id="{{ $variant->id }}" style="display: {{ $loop->first ? 'inline' : 'none' }};">${{ number_format($variant->original_price, 2) }}</span>
                                @endif
                                @endforeach
                            </div>
                            @endif

                            <div class="product__variant">
                                @if($product->variants->count() > 0)
                                <input type="hidden" name="variant_id" id="selected-variant-id" value="{{ $product->variants->first()->id }}">
                                @if($product->variants->pluck('color')->filter()->count() > 0)
                                <div class="product__variant--list mb-10">
                                    <fieldset class="variant__input--fieldset">
                                        <legend class="product__variant--title mb-8">{{ __('detail.color_label') }}</legend>
                                        <div class="variant__color d-flex">
                                            @foreach($product->variants->pluck('color')->filter()->unique('id') as $idx => $color)
                                            @php
                                            $variantIds = $product->variants->where('color_id', $color->id)->pluck('id')->toArray();
                                            @endphp
                                            <div class="variant__color--list">
                                                <input
                                                    id="color-{{ $color->id }}"
                                                    name="color_id"
                                                    type="radio"
                                                    value="{{ $color->id }}"
                                                    data-variant-ids="{{ implode(',', $variantIds) }}"
                                                    @if($loop->first) checked @endif
                                                class="@error('color_id') is-invalid @enderror"
                                                >
                                                <label class="variant__color--value"
                                                    for="color-{{ $color->id }}"
                                                    title="{{ $color->name ?? __('detail.color') }}">
                                                    <div class="variant__color--value__color" style="background-color: {{ $color->code ?? '#cccccc' }}; 
                                                        display:inline-block; width:30px; height:28px; border-radius: 3px;"></div>
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                        @error('color_id')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </fieldset>
                                </div>
                                @endif
                                @if($product->variants->pluck('size')->filter()->count() > 0)
                                <div class="product__variant--list mb-20">
                                    <fieldset class="variant__input--fieldset">
                                        <legend class="product__variant--title mb-8">{{ __('detail.size_label') }}</legend>
                                        <ul class="variant__size d-flex">
                                            @foreach($product->variants->pluck('size')->filter()->unique('id') as $idx => $size)
                                            @php
                                            $variantIds = $product->variants->where('size_id', $size->id)->pluck('id')->toArray();
                                            @endphp
                                            <li class="variant__size--list">
                                                <input id="size-{{ $size->id }}" name="size_id" type="radio" value="{{ $size->id }}" data-variant-ids="{{ implode(',', $variantIds) }}" @if($loop->first) checked @endif class="@error('size_id') is-invalid @enderror">
                                                <label class="variant__size--value" for="size-{{ $size->id }}" title="{{ $size->name ?? __('detail.size') }}">
                                                    {{ $size->name ?? __('detail.size') }}
                                                </label>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @error('size_id')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </fieldset>
                                </div>
                                @endif
                                @endif

                                <div class="product__variant--list quantity d-flex align-items-center mb-20">
                                    <div class="quantity__box">
                                        <button type="button" class="quantity__value quickview__value--quantity decrease" aria-label="{{ __('detail.quantity_value') }}" value="{{ __('detail.decrease_value') }}">-</button>
                                        <label>
                                            <input type="number" name="quantity" class="quantity__number quickview__value--number @error('quantity') is-invalid @enderror" value="{{ old('quantity', 1) }}" data-counter min="1" />
                                        </label>
                                        <button type="button" class="quantity__value quickview__value--quantity increase" aria-label="{{ __('detail.quantity_value') }}" value="{{ __('detail.increase_value') }}">+</button>
                                    </div>
                                    @error('quantity')
                                    <div class="text-danger small ms-2">{{ $message }}</div>
                                    @enderror
                                    <button class="primary__btn quickview__cart--btn" type="submit" form="add-to-cart-form">{{ __('detail.add_to_cart') }}</button>
                                </div>
                                @error('variant_id')
                                <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                                @error('slug')
                                <div class="text-danger small mb-2">{{ $message }}</div>
                                @enderror
                            </div>

                            @if($product->quality)
                            <p class="product__details--info__meta--list"><strong>{{ __('detail.quality') }}</strong> <span>
                                    {{ $product->quality?->name ?? __('detail.not_available') }}
                                </span> </p>
                            @endif

                            @if($product->category)
                            <p class="product__details--info__meta--list"><strong>{{ __('detail.category') }}</strong> <span>
                                    {{ $product->category?->name ?? __('detail.not_available') }}
                                </span> </p>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End product details section -->

    <!-- Start product details tab section -->
    @if($product->placement_image)
    <section class="product__details--tab__section section--padding">
        <div class="container">
            <div class="row row-cols-1">
                <div class="col">
                    <ul class="product__tab--one product__details--tab d-flex mb-30">
                        <li class="product__details--tab__list active" data-toggle="tab" data-target="#description">{{ __('detail.description') }}</li>
                    </ul>
                    <div class="product__details--tab__inner border-radius-10">
                        <div class="tab_content">
                            <div id="description" class="tab_pane active show">
                                <div class="product__tab--content flex flex-col items-center justify-center text-center">
                                    <div class="product__tab--content__step mb-30">
                                        <h2 class="product__tab--content__title h4 mb-10">{{ $product->name }}</h2>
                                        <p class="product__tab--content__desc">
                                            {{ __('detail.description_text') }}
                                        </p>
                                    </div>
                                    <div class="product__tab--content__step style2 mb-30 flex justify-center">
                                        <div class="product__tab--content__banner">
                                            <img class="product__tab--content__banner--img border-radius-5 w-full" src="{{ $product->placement_image }}" alt="{{ __('detail.banner_img') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
    <!-- End product details tab section -->
</main>

@push('styles')
<style>
    @media (min-width: 768px) {
        .product__media--preview__items {
            height: 500px !important;
            padding: 20px !important;
        }
    }

    @media (max-width: 767px) {
        .product__media--preview__items {
            height: 300px !important;
            padding: 10px !important;
        }

        .product__details--media {
            margin-bottom: 0.5rem !important;
        }
    }

    .product__tab--content__step.style2 {
        display: flex !important;
        justify-content: center !important;
    }

    .product__tab--content__banner--img {
        display: block;
        margin: 0 auto;
        width: 100%;
    }

    /* Arabic (RTL) specific styles */
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
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get DOM elements
        const colorInputs = document.querySelectorAll('input[name="color_id"]');
        const sizeInputs = document.querySelectorAll('input[name="size_id"]');
        const variantIdInput = document.getElementById('selected-variant-id');
        const variantImageWrappers = document.querySelectorAll('.variant-image-wrapper');
        const variantZoomWrappers = document.querySelectorAll('.variant-zoom-wrapper');
        const priceElements = document.querySelectorAll('.product-variant-price[data-variant-id]');
        const originalPriceElements = document.querySelectorAll('.product-variant-original-price[data-variant-id]');

        // Function to get variant IDs from a data attribute
        function getVariantIds(element) {
            if (!element || !element.getAttribute('data-variant-ids')) {
                return [];
            }
            const idsString = element.getAttribute('data-variant-ids');
            return idsString.split(',').map(id => parseInt(id.trim())).filter(id => !isNaN(id));
        }

        // Function to find the matching variant ID based on selected color and size
        function findMatchingVariantId() {
            const selectedColor = document.querySelector('input[name="color_id"]:checked');
            const selectedSize = document.querySelector('input[name="size_id"]:checked');

            let colorVariantIds = [];
            let sizeVariantIds = [];

            // Get variant IDs from selected color
            if (selectedColor) {
                colorVariantIds = getVariantIds(selectedColor);
            }

            // Get variant IDs from selected size
            if (selectedSize) {
                sizeVariantIds = getVariantIds(selectedSize);
            }

            // If both color and size are selected, find intersection
            if (colorVariantIds.length > 0 && sizeVariantIds.length > 0) {
                const matchingIds = colorVariantIds.filter(id => sizeVariantIds.includes(id));
                return matchingIds.length > 0 ? matchingIds[0] : null;
            }

            // If only color is selected, return first variant ID from that color
            if (colorVariantIds.length > 0) {
                return colorVariantIds[0];
            }

            // If only size is selected, return first variant ID from that size
            if (sizeVariantIds.length > 0) {
                return sizeVariantIds[0];
            }

            // Fallback: get first variant ID from any input
            if (colorInputs.length > 0 && colorInputs[0].getAttribute('data-variant-ids')) {
                const firstColorIds = getVariantIds(colorInputs[0]);
                if (firstColorIds.length > 0) {
                    return firstColorIds[0];
                }
            }

            if (sizeInputs.length > 0 && sizeInputs[0].getAttribute('data-variant-ids')) {
                const firstSizeIds = getVariantIds(sizeInputs[0]);
                if (firstSizeIds.length > 0) {
                    return firstSizeIds[0];
                }
            }

            return null;
        }

        // Function to find size input that has a specific variant ID
        function findSizeForVariantId(variantId) {
            for (let i = 0; i < sizeInputs.length; i++) {
                const ids = getVariantIds(sizeInputs[i]);
                if (ids.includes(variantId)) {
                    return sizeInputs[i];
                }
            }
            return null;
        }

        // Function to find color input that has a specific variant ID
        function findColorForVariantId(variantId) {
            for (let i = 0; i < colorInputs.length; i++) {
                const ids = getVariantIds(colorInputs[i]);
                if (ids.includes(variantId)) {
                    return colorInputs[i];
                }
            }
            return null;
        }

        // Function to auto-select matching color/size based on variant ID
        function autoSelectMatchingOption(changedInput) {
            const selectedColor = document.querySelector('input[name="color_id"]:checked');
            const selectedSize = document.querySelector('input[name="size_id"]:checked');

            // If color was changed
            if (changedInput === 'color' && selectedColor) {
                const colorVariantIds = getVariantIds(selectedColor);

                // If there's already a size selected, find the intersection
                if (selectedSize) {
                    const sizeVariantIds = getVariantIds(selectedSize);
                    const matchingIds = colorVariantIds.filter(id => sizeVariantIds.includes(id));
                    if (matchingIds.length > 0) {
                        // Both are selected and they match, no need to change
                        return;
                    }
                }

                // No size selected or sizes don't match, select first matching size
                if (colorVariantIds.length > 0) {
                    const firstVariantId = colorVariantIds[0];
                    const matchingSize = findSizeForVariantId(firstVariantId);
                    if (matchingSize && !matchingSize.checked) {
                        matchingSize.checked = true;
                    }
                }
            }

            // If size was changed
            if (changedInput === 'size' && selectedSize) {
                const sizeVariantIds = getVariantIds(selectedSize);

                // If there's already a color selected, find the intersection
                if (selectedColor) {
                    const colorVariantIds = getVariantIds(selectedColor);
                    const matchingIds = sizeVariantIds.filter(id => colorVariantIds.includes(id));
                    if (matchingIds.length > 0) {
                        // Both are selected and they match, no need to change
                        return;
                    }
                }

                // No color selected or colors don't match, select first matching color
                if (sizeVariantIds.length > 0) {
                    const firstVariantId = sizeVariantIds[0];
                    const matchingColor = findColorForVariantId(firstVariantId);
                    if (matchingColor && !matchingColor.checked) {
                        matchingColor.checked = true;
                    }
                }
            }
        }

        // Function to get all variant IDs from color and size inputs
        function getAllVariantIds() {
            const allVariantIds = new Set();

            colorInputs.forEach(input => {
                const ids = getVariantIds(input);
                ids.forEach(id => allVariantIds.add(id));
            });

            sizeInputs.forEach(input => {
                const ids = getVariantIds(input);
                ids.forEach(id => allVariantIds.add(id));
            });

            return Array.from(allVariantIds);
        }

        // Function to check if an ID is a variant ID (not product ID)
        function isVariantId(id, allVariantIds) {
            return allVariantIds.includes(id);
        }

        // Function to update display based on selected variant
        function updateVariantDisplay() {
            const variantId = findMatchingVariantId();
            const allVariantIds = getAllVariantIds();

            // If there are no color/size inputs, don't apply variant-based hiding
            // This means it's a product with a single image, so leave it visible
            const hasVariantOptions = colorInputs.length > 0 || sizeInputs.length > 0;

            if (!variantId && hasVariantOptions) {
                return;
            }

            // Update hidden input
            if (variantIdInput && variantId) {
                variantIdInput.value = variantId;
            }

            // Update images - show selected, hide others
            // Only hide/show if it's a variant image (not product image)
            if (hasVariantOptions && allVariantIds.length > 0) {
                variantImageWrappers.forEach(wrapper => {
                    const wrapperVariantId = parseInt(wrapper.getAttribute('data-variant-id'));

                    // If this is a variant image (not product image), apply hide/show logic
                    if (isVariantId(wrapperVariantId, allVariantIds)) {
                        if (wrapperVariantId === variantId) {
                            wrapper.style.opacity = '1';
                            wrapper.style.pointerEvents = 'auto';
                        } else {
                            wrapper.style.opacity = '0';
                            wrapper.style.pointerEvents = 'none';
                        }
                    }
                    // If it's a product image, leave it visible (don't hide it)
                });

                variantZoomWrappers.forEach(wrapper => {
                    const wrapperVariantId = parseInt(wrapper.getAttribute('data-variant-id'));

                    // If this is a variant zoom wrapper (not product), apply hide/show logic
                    if (isVariantId(wrapperVariantId, allVariantIds)) {
                        if (wrapperVariantId === variantId) {
                            wrapper.style.opacity = '1';
                            wrapper.style.pointerEvents = 'auto';
                        } else {
                            wrapper.style.opacity = '0';
                            wrapper.style.pointerEvents = 'none';
                        }
                    }
                    // If it's a product zoom wrapper, leave it visible
                });
            }

            // Update prices - show selected, hide others
            if (variantId) {
                priceElements.forEach(element => {
                    const elementVariantId = parseInt(element.getAttribute('data-variant-id'));
                    if (elementVariantId === variantId) {
                        element.style.display = 'inline';
                    } else {
                        element.style.display = 'none';
                    }
                });

                originalPriceElements.forEach(element => {
                    const elementVariantId = parseInt(element.getAttribute('data-variant-id'));
                    if (elementVariantId === variantId) {
                        element.style.display = 'inline';
                    } else {
                        element.style.display = 'none';
                    }
                });
            }
        }

        // Add event listeners to color inputs
        colorInputs.forEach(input => {
            input.addEventListener('change', function() {
                // Auto-select matching size
                autoSelectMatchingOption('color');
                // Then update the display
                updateVariantDisplay();
            });
        });

        // Add event listeners to size inputs
        sizeInputs.forEach(input => {
            input.addEventListener('change', function() {
                // Auto-select matching color
                autoSelectMatchingOption('size');
                // Then update the display
                updateVariantDisplay();
            });
        });

        // Initialize with default selection
        updateVariantDisplay();
    });
</script>
@endpush

@endsection