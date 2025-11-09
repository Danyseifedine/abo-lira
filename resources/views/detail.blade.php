@extends('layout.master')

@section('content')

    <main class="main__content_wrapper">

        <!-- Start breadcrumb section -->
        <section class="breadcrumb__section breadcrumb__bg">
            <div class="container">
                <div class="row row-cols-1">
                    <div class="col">
                        <div class="breadcrumb__content text-center">
                            <ul class="breadcrumb__content--menu d-flex justify-content-center">
                                <li class="breadcrumb__content--menu__items"><a href="index.html">{{ __('detail.home') }}</a></li>
                                <li class="breadcrumb__content--menu__items"><span>{{ __('detail.product') }}</span></li>
                            </ul>
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
                                                    style="width: 100%; height: 100%; position: absolute; top: 0; left: 0; transition: opacity 0.3s ease-in-out;"
                                                >
                                                    <img 
                                                        class="product__media--preview__items--img product-variant-image" 
                                                        src="{{ $product->image }}" 
                                                        alt="{{ __('detail.product_media_img') }}" 
                                                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 3px;"
                                                    >
                                                </a>
                                                <div class="product__media--view__icon variant-zoom-wrapper" data-variant-id="{{ $product->id }}" style="position: absolute; top: 10px; left: 10px; opacity: 1; transition: opacity 0.3s ease-in-out; pointer-events: auto;">
                                                    <a 
                                                        class="product__media--view__icon--link glightbox product-variant-zoom-link" 
                                                        href="{{ $product->image }}" 
                                                        data-gallery="product-media-zoom"
                                                    >
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
                                                    style="width: 100%; height: 100%; position: absolute; top: 0; left: 0; opacity: {{ $idx === 0 ? '1' : '0' }}; transition: opacity 0.3s ease-in-out; {{ $idx !== 0 ? 'pointer-events: none;' : '' }}"
                                                >
                                                    <img 
                                                        class="product__media--preview__items--img product-variant-image" 
                                                        src="{{ $variant->image }}" 
                                                        alt="{{ __('detail.product_media_img') }}" 
                                                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 3px;"
                                                    >
                                                </a>
                                                <div class="product__media--view__icon variant-zoom-wrapper" data-variant-id="{{ $variant->id }}" style="position: absolute; top: 10px; left: 10px; opacity: {{ $idx === 0 ? '1' : '0' }}; transition: opacity 0.3s ease-in-out; {{ $idx !== 0 ? 'pointer-events: none;' : '' }}">
                                                    <a 
                                                        class="product__media--view__icon--link glightbox product-variant-zoom-link" 
                                                        href="{{ $variant->image }}" 
                                                        data-gallery="product-media-zoom"
                                                    >
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
                            <form action="#">
                                <h2 class="product__details--info__title mb-15">{{ $product->name }}</h2>
                                @if($product->description)
                                <p class="product__details--info__desc mb-15">
                                    {{ $product->description }}
                                </p>
                                @endif

                                @if($product->variants->count() > 0)
                                   <div class="product__details--info__price mb-12">
                                        <span class="current__price product-variant-price">${{ $product->variants->first()->price }}</span>
                                        @if($product->variants->first()->original_price > $product->variants->first()->price)
                                        <span class="old__price product-variant-original-price">${{ $product->variants->first()->original_price }}</span>
                                        @endif
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
                                                @foreach($product->variants->pluck('color')->filter() as $idx => $color)
                                                <div class="variant__color--list">
                                                    <input
                                                        id="color-{{ $color->id }}"
                                                        name="color"
                                                        type="radio"
                                                        value="{{ $color->id }}"
                                                        @if($loop->first) checked @endif
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
                                        </fieldset>
                                    </div>
                                    @endif
                                    @if($product->variants->pluck('size')->filter()->count() > 0)
                                    <div class="product__variant--list mb-20">
                                        <fieldset class="variant__input--fieldset">
                                            <legend class="product__variant--title mb-8">{{ __('detail.size_label') }}</legend>
                                            <ul class="variant__size d-flex">
                                                @foreach($product->variants->pluck('size')->filter() as $idx => $size)
                                                <li class="variant__size--list">
                                                    <input id="size-{{ $size->id }}" name="size" type="radio" value="{{ $size->id }}" @if($loop->first) checked @endif>
                                                    <label class="variant__size--value" for="size-{{ $size->id }}" title="{{ $size->name ?? __('detail.size') }}">
                                                        {{ $size->name ?? __('detail.size') }}
                                                    </label>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </fieldset>
                                    </div>
                                    @endif
                                    @endif

                                    <div class="product__variant--list quantity d-flex align-items-center mb-20">
                                        <div class="quantity__box">
                                            <button type="button" class="quantity__value quickview__value--quantity decrease" aria-label="{{ __('detail.quantity_value') }}" value="{{ __('detail.decrease_value') }}">-</button>
                                            <label>
                                                <input type="number" class="quantity__number quickview__value--number" value="1" data-counter />
                                            </label>
                                            <button type="button" class="quantity__value quickview__value--quantity increase" aria-label="{{ __('detail.quantity_value') }}" value="{{ __('detail.increase_value') }}">+</button>
                                        </div>
                                        <button class="primary__btn quickview__cart--btn" type="submit">{{ __('detail.add_to_cart') }}</button>
                                    </div>
                                </div>

                                @if($product->quality)
                                    <p class="product__details--info__meta--list"><strong>{{ __('detail.quality') }}</strong>  <span>
                                    {{ $product->quality?->name ?? __('detail.not_available') }}
                                    </span> </p>
                                @endif

                                @if($product->category)
                                    <p class="product__details--info__meta--list"><strong>{{ __('detail.category') }}</strong>  <span>
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
    @php
        $hasProductImage = !empty($product->image);
        $hasColors = $product->variants->pluck('color')->filter()->count() > 0;
        $hasSizes = $product->variants->pluck('size')->filter()->count() > 0;
        
        $variantsData = $product->variants->map(function($variant) {
            return [
                'id' => $variant->id,
                'color_id' => $variant->color_id,
                'size_id' => $variant->size_id,
                'image' => $variant->image,
                'price' => (float) $variant->price,
                'original_price' => (float) ($variant->original_price ?? $variant->price),
            ];
        })->values();
        
        // Get all available colors and sizes for filtering
        $allColors = $product->variants->pluck('color')->filter()->unique('id')->map(function($color) {
            return [
                'id' => $color->id,
                'name' => $color->name,
                'code' => $color->code,
            ];
        })->values();
        
        $allSizes = $product->variants->pluck('size')->filter()->unique('id')->map(function($size) {
            return [
                'id' => $size->id,
                'name' => $size->name,
            ];
        })->values();
    @endphp
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get variants data from PHP
            const variants = @json($variantsData);
            const hasProductImage = @json($hasProductImage);
            const hasColors = @json($hasColors);
            const hasSizes = @json($hasSizes);
            const allColors = @json($allColors);
            const allSizes = @json($allSizes);

            // Get DOM elements
            const colorInputs = document.querySelectorAll('input[name="color"]');
            const sizeInputs = document.querySelectorAll('input[name="size"]');
            const variantIdInput = document.getElementById('selected-variant-id');
            const variantImageWrappers = document.querySelectorAll('.variant-image-wrapper');
            const variantZoomWrappers = document.querySelectorAll('.variant-zoom-wrapper');
            const priceElement = document.querySelector('.product-variant-price');
            const originalPriceElement = document.querySelector('.product-variant-original-price');

            // Track if this is the initial load
            let isInitialLoad = true;
            // Track if we're programmatically updating (to prevent recursive calls)
            let isProgrammaticUpdate = false;

            // Function to find variant based on color and size
            function findVariant(colorId, sizeId) {
                return variants.find(variant => {
                    const colorMatch = colorId 
                        ? (variant.color_id && parseInt(variant.color_id) === parseInt(colorId))
                        : !variant.color_id;
                    const sizeMatch = sizeId 
                        ? (variant.size_id && parseInt(variant.size_id) === parseInt(sizeId))
                        : !variant.size_id;
                    return colorMatch && sizeMatch;
                });
            }

            // Function to get available sizes for a selected color
            function getAvailableSizesForColor(colorId) {
                if (!colorId) return allSizes;
                return allSizes.filter(size => {
                    return variants.some(variant => 
                        variant.color_id && parseInt(variant.color_id) === parseInt(colorId) &&
                        variant.size_id && parseInt(variant.size_id) === parseInt(size.id)
                    );
                });
            }

            // Function to get available colors for a selected size
            function getAvailableColorsForSize(sizeId) {
                if (!sizeId) return allColors;
                return allColors.filter(color => {
                    return variants.some(variant => 
                        variant.size_id && parseInt(variant.size_id) === parseInt(sizeId) &&
                        variant.color_id && parseInt(variant.color_id) === parseInt(color.id)
                    );
                });
            }

            // Function to show all options (used on initial load)
            function showAllOptions() {
                if (!hasProductImage && hasColors && hasSizes) {
                    // Show all sizes
                    sizeInputs.forEach(input => {
                        const listItem = input.closest('.variant__size--list');
                        if (listItem) {
                            listItem.style.display = '';
                            input.disabled = false;
                        }
                    });

                    // Show all colors
                    colorInputs.forEach(input => {
                        const listItem = input.closest('.variant__color--list');
                        if (listItem) {
                            listItem.style.display = '';
                            input.disabled = false;
                        }
                    });
                }
            }

            // Function to update available options (sizes/colors) based on selection
            function updateAvailableOptions(changedInput = null) {
                // On initial load, show all options
                if (isInitialLoad) {
                    showAllOptions();
                    return;
                }

                const selectedColor = document.querySelector('input[name="color"]:checked');
                const selectedSize = document.querySelector('input[name="size"]:checked');
                
                const colorId = selectedColor ? selectedColor.value : null;
                const sizeId = selectedSize ? selectedSize.value : null;

                // Scenario 3: Both colors and sizes exist, and no product image
                if (!hasProductImage && hasColors && hasSizes) {
                    // If color changed, filter sizes but show all colors
                    if (changedInput === 'color' && selectedColor) {
                        const availableSizes = getAvailableSizesForColor(colorId);
                        let needsSizeReselection = false;
                        
                        sizeInputs.forEach(input => {
                            const inputSizeId = parseInt(input.value);
                            const isAvailable = availableSizes.some(size => parseInt(size.id) === inputSizeId);
                            const listItem = input.closest('.variant__size--list');
                            if (listItem) {
                                // Always show the size option and keep it clickable
                                listItem.style.display = '';
                                input.disabled = false;
                                if (!isAvailable && input.checked) {
                                    needsSizeReselection = true;
                                }
                            }
                        });
                        
                        // If current size selection is not available, select first available
                        if (needsSizeReselection) {
                            const firstAvailable = Array.from(sizeInputs).find(inp => {
                                const id = parseInt(inp.value);
                                return availableSizes.some(s => parseInt(s.id) === id);
                            });
                            if (firstAvailable) {
                                isProgrammaticUpdate = true;
                                firstAvailable.checked = true;
                                // Update display without filtering again (just update image/price)
                                const currentColor = document.querySelector('input[name="color"]:checked');
                                const finalColorId = currentColor ? currentColor.value : null;
                                const finalSizeId = firstAvailable.value;
                                const variant = findVariant(finalColorId, finalSizeId) || variants[0];
                                if (variant) {
                                    if (variantIdInput) variantIdInput.value = variant.id;
                                    if (priceElement) priceElement.textContent = '$' + parseFloat(variant.price).toFixed(2);
                                    if (originalPriceElement) {
                                        if (variant.original_price > variant.price) {
                                            originalPriceElement.textContent = '$' + parseFloat(variant.original_price).toFixed(2);
                                            originalPriceElement.style.display = 'inline';
                                        } else {
                                            originalPriceElement.style.display = 'none';
                                        }
                                    }
                                    // Update image
                                    variantImageWrappers.forEach(wrapper => {
                                        const variantId = parseInt(wrapper.getAttribute('data-variant-id'));
                                        wrapper.style.opacity = variantId === variant.id ? '1' : '0';
                                        wrapper.style.pointerEvents = variantId === variant.id ? 'auto' : 'none';
                                    });
                                    variantZoomWrappers.forEach(wrapper => {
                                        const variantId = parseInt(wrapper.getAttribute('data-variant-id'));
                                        wrapper.style.opacity = variantId === variant.id ? '1' : '0';
                                        wrapper.style.pointerEvents = variantId === variant.id ? 'auto' : 'none';
                                    });
                                }
                                isProgrammaticUpdate = false;
                            }
                        }
                        
                        // Show all colors (don't filter colors when color changes)
                        colorInputs.forEach(input => {
                            const listItem = input.closest('.variant__color--list');
                            if (listItem) {
                                listItem.style.display = '';
                                input.disabled = false;
                            }
                        });
                    }
                    // If size changed, filter colors but show all sizes
                    else if (changedInput === 'size' && selectedSize) {
                        const availableColors = getAvailableColorsForSize(sizeId);
                        let needsColorReselection = false;
                        
                        colorInputs.forEach(input => {
                            const inputColorId = parseInt(input.value);
                            const isAvailable = availableColors.some(color => parseInt(color.id) === inputColorId);
                            const listItem = input.closest('.variant__color--list');
                            if (listItem) {
                                // Always show the color option and keep it clickable
                                listItem.style.display = '';
                                input.disabled = false;
                                if (!isAvailable && input.checked) {
                                    needsColorReselection = true;
                                }
                            }
                        });
                        
                        // If current color selection is not available, select first available
                        if (needsColorReselection) {
                            const firstAvailable = Array.from(colorInputs).find(inp => {
                                const id = parseInt(inp.value);
                                return availableColors.some(c => parseInt(c.id) === id);
                            });
                            if (firstAvailable) {
                                isProgrammaticUpdate = true;
                                firstAvailable.checked = true;
                                // Update display without filtering again (just update image/price)
                                const finalColorId = firstAvailable.value;
                                const currentSize = document.querySelector('input[name="size"]:checked');
                                const finalSizeId = currentSize ? currentSize.value : null;
                                const variant = findVariant(finalColorId, finalSizeId) || variants[0];
                                if (variant) {
                                    if (variantIdInput) variantIdInput.value = variant.id;
                                    if (priceElement) priceElement.textContent = '$' + parseFloat(variant.price).toFixed(2);
                                    if (originalPriceElement) {
                                        if (variant.original_price > variant.price) {
                                            originalPriceElement.textContent = '$' + parseFloat(variant.original_price).toFixed(2);
                                            originalPriceElement.style.display = 'inline';
                                        } else {
                                            originalPriceElement.style.display = 'none';
                                        }
                                    }
                                    // Update image
                                    variantImageWrappers.forEach(wrapper => {
                                        const variantId = parseInt(wrapper.getAttribute('data-variant-id'));
                                        wrapper.style.opacity = variantId === variant.id ? '1' : '0';
                                        wrapper.style.pointerEvents = variantId === variant.id ? 'auto' : 'none';
                                    });
                                    variantZoomWrappers.forEach(wrapper => {
                                        const variantId = parseInt(wrapper.getAttribute('data-variant-id'));
                                        wrapper.style.opacity = variantId === variant.id ? '1' : '0';
                                        wrapper.style.pointerEvents = variantId === variant.id ? 'auto' : 'none';
                                    });
                                }
                                isProgrammaticUpdate = false;
                            }
                        }
                        
                        // Show all sizes (don't filter sizes when size changes)
                        sizeInputs.forEach(input => {
                            const listItem = input.closest('.variant__size--list');
                            if (listItem) {
                                listItem.style.display = '';
                                input.disabled = false;
                            }
                        });
                    }
                    // If no specific change detected, apply both filters (fallback)
                    else {
                        // Update sizes based on selected color
                        if (selectedColor) {
                            const availableSizes = getAvailableSizesForColor(colorId);
                            sizeInputs.forEach(input => {
                                const inputSizeId = parseInt(input.value);
                                const isAvailable = availableSizes.some(size => parseInt(size.id) === inputSizeId);
                                const listItem = input.closest('.variant__size--list');
                                if (listItem) {
                                    // Always show the size option and keep it clickable
                                    listItem.style.display = '';
                                    input.disabled = false;
                                }
                            });
                        } else {
                            // Show all sizes if no color selected
                            sizeInputs.forEach(input => {
                                const listItem = input.closest('.variant__size--list');
                                if (listItem) {
                                    listItem.style.display = '';
                                    input.disabled = false;
                                }
                            });
                        }

                        // Update colors based on selected size
                        if (selectedSize) {
                            const availableColors = getAvailableColorsForSize(sizeId);
                            colorInputs.forEach(input => {
                                const inputColorId = parseInt(input.value);
                                const isAvailable = availableColors.some(color => parseInt(color.id) === inputColorId);
                                const listItem = input.closest('.variant__color--list');
                                if (listItem) {
                                    // Always show the color option and keep it clickable
                                    listItem.style.display = '';
                                    input.disabled = false;
                                }
                            });
                        } else {
                            // Show all colors if no size selected
                            colorInputs.forEach(input => {
                                const listItem = input.closest('.variant__color--list');
                                if (listItem) {
                                    listItem.style.display = '';
                                    input.disabled = false;
                                }
                            });
                        }
                    }
                }
            }

            // Function to update product display based on selected variant
            function updateVariantDisplay(changedInput = null) {
                const selectedColor = document.querySelector('input[name="color"]:checked');
                const selectedSize = document.querySelector('input[name="size"]:checked');
                
                const colorId = selectedColor ? selectedColor.value : null;
                const sizeId = selectedSize ? selectedSize.value : null;

                // Scenario 1: Sizes only (product has image)
                if (hasProductImage && hasSizes) {
                    // Only update price when size changes
                    const variant = findVariant(null, sizeId) || variants[0];
                    if (variant) {
                        if (variantIdInput) {
                            variantIdInput.value = variant.id;
                        }
                        if (priceElement) {
                            priceElement.textContent = '$' + parseFloat(variant.price).toFixed(2);
                        }
                        if (originalPriceElement) {
                            if (variant.original_price > variant.price) {
                                originalPriceElement.textContent = '$' + parseFloat(variant.original_price).toFixed(2);
                                originalPriceElement.style.display = 'inline';
                            } else {
                                originalPriceElement.style.display = 'none';
                            }
                        }
                    }
                    return;
                }

                // Scenario 2: Colors only (no product image, only colors)
                if (!hasProductImage && hasColors && !hasSizes) {
                    const variant = findVariant(colorId, null) || variants[0];
                    if (variant) {
                        if (variantIdInput) {
                            variantIdInput.value = variant.id;
                        }
                        
                        // Update image
                        variantImageWrappers.forEach(wrapper => {
                            const variantId = parseInt(wrapper.getAttribute('data-variant-id'));
                            if (variantId === variant.id) {
                                wrapper.style.opacity = '1';
                                wrapper.style.pointerEvents = 'auto';
                            } else {
                                wrapper.style.opacity = '0';
                                wrapper.style.pointerEvents = 'none';
                            }
                        });

                        variantZoomWrappers.forEach(wrapper => {
                            const variantId = parseInt(wrapper.getAttribute('data-variant-id'));
                            if (variantId === variant.id) {
                                wrapper.style.opacity = '1';
                                wrapper.style.pointerEvents = 'auto';
                            } else {
                                wrapper.style.opacity = '0';
                                wrapper.style.pointerEvents = 'none';
                            }
                        });

                        // Update price
                        if (priceElement) {
                            priceElement.textContent = '$' + parseFloat(variant.price).toFixed(2);
                        }
                        if (originalPriceElement) {
                            if (variant.original_price > variant.price) {
                                originalPriceElement.textContent = '$' + parseFloat(variant.original_price).toFixed(2);
                                originalPriceElement.style.display = 'inline';
                            } else {
                                originalPriceElement.style.display = 'none';
                            }
                        }
                    }
                    return;
                }

                // Scenario 3: Colors and sizes (no product image, has both)
                if (!hasProductImage && hasColors && hasSizes) {
                    // Update available options (will show all on initial load, filter on user interaction)
                    updateAvailableOptions(changedInput);
                    
                    // Get current selections after filtering
                    const currentColor = document.querySelector('input[name="color"]:checked');
                    const currentSize = document.querySelector('input[name="size"]:checked');
                    const finalColorId = currentColor ? currentColor.value : null;
                    const finalSizeId = currentSize ? currentSize.value : null;

                    const variant = findVariant(finalColorId, finalSizeId) || variants[0];
                    if (variant) {
                        if (variantIdInput) {
                            variantIdInput.value = variant.id;
                        }
                        
                        // Update image
                        variantImageWrappers.forEach(wrapper => {
                            const variantId = parseInt(wrapper.getAttribute('data-variant-id'));
                            if (variantId === variant.id) {
                                wrapper.style.opacity = '1';
                                wrapper.style.pointerEvents = 'auto';
                            } else {
                                wrapper.style.opacity = '0';
                                wrapper.style.pointerEvents = 'none';
                            }
                        });

                        variantZoomWrappers.forEach(wrapper => {
                            const variantId = parseInt(wrapper.getAttribute('data-variant-id'));
                            if (variantId === variant.id) {
                                wrapper.style.opacity = '1';
                                wrapper.style.pointerEvents = 'auto';
                            } else {
                                wrapper.style.opacity = '0';
                                wrapper.style.pointerEvents = 'none';
                            }
                        });

                        // Update price
                        if (priceElement) {
                            priceElement.textContent = '$' + parseFloat(variant.price).toFixed(2);
                        }
                        if (originalPriceElement) {
                            if (variant.original_price > variant.price) {
                                originalPriceElement.textContent = '$' + parseFloat(variant.original_price).toFixed(2);
                                originalPriceElement.style.display = 'inline';
                            } else {
                                originalPriceElement.style.display = 'none';
                            }
                        }
                    }
                    return;
                }

                // Fallback: Default behavior
                const variant = findVariant(colorId, sizeId) || variants[0];
                if (variant) {
                    if (variantIdInput) {
                        variantIdInput.value = variant.id;
                    }
                    if (priceElement) {
                        priceElement.textContent = '$' + parseFloat(variant.price).toFixed(2);
                    }
                }
            }

            // Add event listeners to color inputs
            colorInputs.forEach(input => {
                input.addEventListener('change', function() {
                    if (isProgrammaticUpdate) return;
                    isInitialLoad = false;
                    updateVariantDisplay('color');
                });
            });

            // Add event listeners to size inputs
            sizeInputs.forEach(input => {
                input.addEventListener('change', function() {
                    if (isProgrammaticUpdate) return;
                    isInitialLoad = false;
                    updateVariantDisplay('size');
                });
            });

            // Initialize with default selection (shows all options initially)
            updateVariantDisplay();
            // Mark initial load as complete after initialization
            isInitialLoad = false;
        });
    </script>
    @endpush

@endsection
