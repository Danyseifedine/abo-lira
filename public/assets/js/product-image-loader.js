/**
 * Product Image Lazy Loading Implementation
 * Optimized for e-commerce product cards and swiper galleries
 */

(function () {
    'use strict';

    /**
     * ProductImageLoader - Specialized lazy loader for product images
     * Extends the base LazyImageLoader with product-specific optimizations
     */
    class ProductImageLoader {
        constructor(options = {}) {
            // Merge default product-specific options
            this.options = {
                // Selectors optimized for product cards
                imageSelector: '.product__card--image[data-src]',
                containerSelectors: ['.product__section--inner', '.swiper-wrapper'],

                // Loading behavior
                rootMargin: '500px', // Increased to start loading earlier
                threshold: [0, 0.1, 0.5],
                loadingAttribute: 'data-src',
                concurrent: 10, // Maximum concurrent loading for very fast performance

                // Visual settings for product images
                fadeIn: true,
                fadeDuration: 200, // Reduced for faster visual feedback
                productImageHeight: '250px',
                productImageWidth: '100%',
                objectFit: 'cover',

                // Performance - Optimized for maximum speed
                debounceDelay: 10, // Reduced for faster response
                scrollThrottle: 16, // One frame (60fps) for smooth scrolling
                checkDelay: 50, // Reduced for faster initial load
                useRequestIdleCallback: false, // Disabled for immediate processing

                // Swiper detection
                detectSwiper: true,
                swiperSelectors: ['.swiper-slide', '.product__card'],

                ...options
            };

            // Internal state
            this.processedImages = new WeakSet();
            this.loadingImages = new Set();
            this.loadQueue = [];
            this.activeLoads = 0;
            this.scrollTicking = false;
            this.observers = {
                intersection: null,
                mutation: [],
                resizeObserver: null
            };
            this.timers = {
                debounce: null,
                scroll: null,
                check: null
            };

            // Bind methods
            this.loadImage = this.loadImage.bind(this);
            this.handleIntersection = this.handleIntersection.bind(this);
            this.handleScroll = this.handleScroll.bind(this);
            this.observeImages = this.observeImages.bind(this);

            // Initialize
            this.init();
        }

        /**
         * Initialize the loader
         */
        init() {
            this.injectStyles();

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', () => this.start());
            } else {
                this.start();
            }
        }

        /**
         * Start observing and loading
         */
        start() {
            // Setup intersection observer
            this.setupIntersectionObserver();

            // Initial observation - immediate
            this.observeImages();

            // Check again quickly to catch any missed images
            setTimeout(() => this.observeImages(), this.options.checkDelay);

            // Additional immediate check for maximum coverage
            requestAnimationFrame(() => this.observeImages());

            // Setup mutation observers for dynamic content
            this.setupMutationObservers();

            // Setup scroll listener as fallback
            this.setupScrollListener();

            // Setup resize observer for responsive behavior
            if ('ResizeObserver' in window) {
                this.setupResizeObserver();
            }
        }

        /**
         * Setup Intersection Observer for lazy loading
         */
        setupIntersectionObserver() {
            if (!('IntersectionObserver' in window)) {
                console.warn('IntersectionObserver not supported, falling back to scroll-based loading');
                this.fallbackToScroll();
                return;
            }

            this.observers.intersection = new IntersectionObserver(
                this.handleIntersection,
                {
                    rootMargin: this.options.rootMargin,
                    threshold: this.options.threshold
                }
            );
        }

        /**
         * Handle intersection observer callbacks
         */
        handleIntersection(entries) {
            const toLoad = [];

            entries.forEach(entry => {
                if (entry.isIntersecting && !this.isProcessed(entry.target)) {
                    this.observers.intersection.unobserve(entry.target);
                    toLoad.push(entry.target);
                }
            });

            // Add to queue with priority (they're intersecting = visible)
            toLoad.forEach(img => this.queueImage(img, true));
        }

        /**
         * Queue an image for loading (respects concurrent limit)
         * Prioritizes visible images
         */
        queueImage(img, priority = false) {
            // Skip if already processed, loading, or in queue
            if (this.isProcessed(img) || this.isLoading(img) || this.loadQueue.includes(img)) {
                return;
            }

            const actualSrc = img.getAttribute(this.options.loadingAttribute);
            if (!actualSrc) return;

            // Add to queue with priority (visible images go to front)
            if (priority) {
                this.loadQueue.unshift(img);
            } else {
                this.loadQueue.push(img);
            }

            // Process queue immediately
            this.processQueue();
        }

        /**
         * Process the loading queue with concurrent limit
         */
        processQueue() {
            // Start loading images up to the concurrent limit
            while (this.activeLoads < this.options.concurrent && this.loadQueue.length > 0) {
                const img = this.loadQueue.shift();
                this.loadImage(img);
            }
        }

        /**
         * Load a single image with maximum performance
         */
        loadImage(img) {
            // Skip if already processed or loading
            if (this.isProcessed(img) || this.isLoading(img)) {
                return;
            }

            const actualSrc = img.getAttribute(this.options.loadingAttribute);
            if (!actualSrc) {
                this.processQueue(); // Try next in queue
                return;
            }

            // Increment active loads counter
            this.activeLoads++;

            // Mark as loading
            this.markAsLoading(img);

            // Create preloader with fetchpriority hint for modern browsers
            const preloadImg = new Image();

            // Use fetchpriority="high" for faster loading (modern browsers)
            if ('fetchPriority' in preloadImg) {
                preloadImg.fetchPriority = 'high';
            }

            preloadImg.onload = () => {
                this.applyLoadedImage(img, actualSrc);
                this.markAsLoaded(img);
                this.activeLoads--;
                // Process next in queue immediately
                this.processQueue();
            };

            preloadImg.onerror = () => {
                this.handleLoadError(img);
                this.activeLoads--;
                // Process next in queue immediately
                this.processQueue();
            };

            // Start loading immediately - browser handles concurrency
            preloadImg.src = actualSrc;
        }

        /**
         * Apply loaded image with optimized transition
         */
        applyLoadedImage(img, src) {
            // Apply source immediately for fastest display
            img.src = src;
            img.style.objectFit = this.options.objectFit;
            img.style.height = this.options.productImageHeight;
            img.style.width = this.options.productImageWidth;

            // Use single requestAnimationFrame for immediate update
            requestAnimationFrame(() => {
                img.style.transition = `opacity ${this.options.fadeDuration}ms ease-in-out`;
                img.style.opacity = '1';
                img.classList.add('loaded');
            });
        }

        /**
         * Handle image load error
         */
        handleLoadError(img) {
            img.classList.add('error');
            this.unmarkAsLoading(img);
            console.error('Failed to load image:', img.getAttribute(this.options.loadingAttribute));
        }

        /**
         * Mark image as loading
         */
        markAsLoading(img) {
            img.dataset.loading = 'true';
            this.loadingImages.add(img);
        }

        /**
         * Mark image as loaded
         */
        markAsLoaded(img) {
            this.processedImages.add(img);
            this.unmarkAsLoading(img);
            img.removeAttribute(this.options.loadingAttribute);
            img.removeAttribute('data-loading');
        }

        /**
         * Unmark image as loading
         */
        unmarkAsLoading(img) {
            delete img.dataset.loading;
            this.loadingImages.delete(img);
        }

        /**
         * Check if image is processed
         */
        isProcessed(img) {
            return this.processedImages.has(img);
        }

        /**
         * Check if image is loading
         */
        isLoading(img) {
            return img.dataset.loading === 'true' || this.loadingImages.has(img);
        }

        /**
         * Check if element is visible
         */
        isElementVisible(el) {
            const rect = el.getBoundingClientRect();
            const windowHeight = window.innerHeight || document.documentElement.clientHeight;
            const windowWidth = window.innerWidth || document.documentElement.clientWidth;

            return (
                rect.top >= -200 &&
                rect.left >= 0 &&
                rect.bottom <= windowHeight + 200 &&
                rect.right <= windowWidth
            );
        }

        /**
         * Load all visible images with priority
         */
        loadVisibleImages() {
            const allImages = this.getAllImages();
            const visibleImages = Array.from(allImages).filter(img => {
                return this.isElementVisible(img) && !this.isProcessed(img) && !this.isLoading(img);
            });

            // Queue visible images with priority for immediate loading
            visibleImages.forEach(img => this.queueImage(img, true));
            return allImages;
        }

        /**
         * Observe all images
         */
        observeImages() {
            const allImages = this.loadVisibleImages();

            if (this.observers.intersection) {
                allImages.forEach(img => {
                    if (!this.isProcessed(img) && !this.isLoading(img)) {
                        this.observers.intersection.observe(img);
                    }
                });
            }
        }

        /**
         * Debounced observe for performance - optimized for speed
         */
        debouncedObserve() {
            clearTimeout(this.timers.debounce);

            this.timers.debounce = setTimeout(() => {
                // Process immediately for maximum speed
                this.observeImages();
            }, this.options.debounceDelay);
        }

        /**
         * Setup mutation observers for dynamic content
         */
        setupMutationObservers() {
            // Clear existing observers
            this.observers.mutation.forEach(observer => observer.disconnect());
            this.observers.mutation = [];

            const mutationCallback = (mutations) => {
                let hasNewImages = false;

                mutations.forEach(mutation => {
                    mutation.addedNodes.forEach(node => {
                        if (node.nodeType === 1) { // Element node
                            if (this.nodeHasOrIsProductImage(node)) {
                                hasNewImages = true;
                            }
                        }
                    });
                });

                if (hasNewImages) {
                    this.debouncedObserve();
                }
            };

            // Observe each container
            this.options.containerSelectors.forEach(selector => {
                const containers = document.querySelectorAll(selector);
                containers.forEach(container => {
                    const observer = new MutationObserver(mutationCallback);
                    observer.observe(container, {
                        childList: true,
                        subtree: true
                    });
                    this.observers.mutation.push(observer);
                });
            });
        }

        /**
         * Check if node has or is a product image
         */
        nodeHasOrIsProductImage(node) {
            if (!node.classList) return false;

            // Check if it's a swiper slide or product card
            if (this.options.detectSwiper) {
                for (const selector of this.options.swiperSelectors) {
                    const className = selector.replace('.', '');
                    if (node.classList.contains(className)) {
                        return true;
                    }
                }
            }

            // Check if it contains product images
            if (node.querySelector) {
                return !!node.querySelector(this.options.imageSelector);
            }

            // Check if it is a product image
            if (node.matches) {
                return node.matches(this.options.imageSelector);
            }

            return false;
        }

        /**
         * Setup scroll listener as fallback - optimized for 60fps
         */
        setupScrollListener() {
            let ticking = false;

            const scrollHandler = () => {
                if (!ticking) {
                    window.requestAnimationFrame(() => {
                        this.loadVisibleImages();
                        ticking = false;
                    });
                    ticking = true;
                }
            };

            window.addEventListener('scroll', scrollHandler, { passive: true });
        }

        /**
         * Setup resize observer for responsive images
         */
        setupResizeObserver() {
            let resizeTimeout;

            this.observers.resizeObserver = new ResizeObserver(entries => {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(() => {
                    // Recheck images after resize
                    this.observeImages();
                }, 200);
            });

            // Observe the body or main container
            this.observers.resizeObserver.observe(document.body);
        }

        /**
         * Fallback for browsers without IntersectionObserver
         */
        fallbackToScroll() {
            // Just use scroll-based loading
            this.loadVisibleImages();

            window.addEventListener('scroll', this.handleScroll, { passive: true });
            window.addEventListener('resize', this.handleScroll, { passive: true });
        }

        /**
         * Handle scroll events - optimized with requestAnimationFrame
         */
        handleScroll() {
            if (!this.scrollTicking) {
                window.requestAnimationFrame(() => {
                    this.loadVisibleImages();
                    this.scrollTicking = false;
                });
                this.scrollTicking = true;
            }
        }

        /**
         * Get all lazy-loadable images
         */
        getAllImages() {
            return document.querySelectorAll(this.options.imageSelector);
        }

        /**
         * Inject CSS styles
         */
        injectStyles() {
            if (document.getElementById('product-lazy-styles')) return;

            const style = document.createElement('style');
            style.id = 'product-lazy-styles';
            style.textContent = `
                .product__card--image {
                    transition: opacity ${this.options.fadeDuration}ms ease-in-out;
                    will-change: opacity;
                }

                .product__card--image[data-loading="true"] {
                    opacity: 0.5;
                }

                .product__card--image.loaded {
                    opacity: 1 !important;
                }

                .product__card--image.error {
                    opacity: 1;
                    background: #f5f5f5;
                }

                /* Smooth transitions for swiper slides */
                .swiper-slide .product__card--image {
                    transition: opacity ${this.options.fadeDuration}ms ease-in-out,
                               transform 0.3s ease;
                }

                /* Skeleton loading effect */
                .product__card--image:not(.loaded):not(.error) {
                    background: linear-gradient(
                        90deg,
                        #f0f0f0 25%,
                        #e0e0e0 50%,
                        #f0f0f0 75%
                    );
                    background-size: 200% 100%;
                    animation: loading 1.5s infinite;
                }

                @keyframes loading {
                    0% {
                        background-position: 200% 0;
                    }
                    100% {
                        background-position: -200% 0;
                    }
                }

                /* Optimize rendering */
                .product__section--inner,
                .swiper-wrapper {
                    will-change: scroll-position;
                }

                /* Ensure proper sizing during load */
                .product__card--image {
                    display: block;
                    min-height: ${this.options.productImageHeight};
                    width: ${this.options.productImageWidth};
                    object-fit: ${this.options.objectFit};
                }
            `;

            document.head.appendChild(style);
        }

        /**
         * Refresh - rescan for new images
         */
        refresh() {
            this.observeImages();
        }

        /**
         * Destroy and cleanup
         */
        destroy() {
            // Clear timers
            Object.values(this.timers).forEach(timer => clearTimeout(timer));

            // Disconnect observers
            if (this.observers.intersection) {
                this.observers.intersection.disconnect();
            }

            this.observers.mutation.forEach(observer => observer.disconnect());

            if (this.observers.resizeObserver) {
                this.observers.resizeObserver.disconnect();
            }

            // Remove event listeners
            window.removeEventListener('scroll', this.handleScroll);
            window.removeEventListener('resize', this.handleScroll);

            // Clear sets and queue
            this.processedImages = new WeakSet();
            this.loadingImages.clear();
            this.loadQueue = [];
            this.activeLoads = 0;

            // Remove styles
            const styles = document.getElementById('product-lazy-styles');
            if (styles) {
                styles.remove();
            }
        }

        /**
         * Get loading statistics
         */
        getStats() {
            const allImages = this.getAllImages();
            const loaded = Array.from(allImages).filter(img => this.isProcessed(img)).length;
            const loading = this.loadingImages.size;
            const total = allImages.length;
            const pending = total - loaded - loading;

            return {
                total,
                loaded,
                loading,
                pending,
                percentage: total > 0 ? (loaded / total) * 100 : 0
            };
        }
    }

    /**
     * Auto-initialize on DOM ready with your specific configuration
     */
    const initializeProductLazyLoader = () => {
        // Create instance with your specific settings
        window.productImageLoader = new ProductImageLoader({
            imageSelector: '.product__card--image[data-src]',
            containerSelectors: ['.product__section--inner', '.swiper-wrapper'],
            rootMargin: '500px', // Increased for earlier loading
            threshold: [0, 0.1, 0.5],
            concurrent: 10, // Maximum concurrent loading for ultra-fast performance
            fadeIn: true,
            fadeDuration: 200, // Reduced for faster visual feedback
            productImageHeight: '250px',
            productImageWidth: '100%',
            objectFit: 'cover',
            debounceDelay: 10, // Minimal delay for maximum responsiveness
            scrollThrottle: 16, // One frame (60fps)
            checkDelay: 50, // Fast recheck
            detectSwiper: true,
            swiperSelectors: ['.swiper-slide', '.product__card'],
            useRequestIdleCallback: false // Disabled for immediate processing
        });

        // Log initial stats
        console.log('Product Image Loader initialized');

        // Optional: Log stats periodically during development
        if (window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1') {
            setInterval(() => {
                const stats = window.productImageLoader.getStats();
                console.log('Loading stats:', stats);
            }, 5000);
        }

        // Optional: Expose refresh method for debugging
        window.refreshProductImages = () => {
            window.productImageLoader.refresh();
            console.log('Product images refreshed');
        };
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeProductLazyLoader);
    } else {
        // DOM is already loaded
        initializeProductLazyLoader();
    }

    // Also make the class available globally if needed
    window.ProductImageLoader = ProductImageLoader;

})();
