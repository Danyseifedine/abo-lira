/**
 * Product Image Lazy Loading with Placeholder
 * Smooth loading without flashing - optimized for performance
 */
(function() {
    'use strict';
    
    // Track processed images to avoid duplicate loading
    const processedImages = new WeakSet();
    let imageObserver = null;
    let mutationObserver = null;
    let checkTimeout = null;
    
    function isElementVisible(el) {
        const rect = el.getBoundingClientRect();
        const windowHeight = window.innerHeight || document.documentElement.clientHeight;
        const windowWidth = window.innerWidth || document.documentElement.clientWidth;
        
        return (
            rect.top >= -200 && // 200px above viewport
            rect.left >= 0 &&
            rect.bottom <= windowHeight + 200 && // 200px below viewport
            rect.right <= windowWidth
        );
    }
    
    function loadImage(img) {
        // Skip if already processed or loading
        if (processedImages.has(img) || img.dataset.loading === 'true') {
            return;
        }
        
        const actualSrc = img.getAttribute('data-src');
        if (!actualSrc) return;
        
        // Mark as loading to prevent duplicate loads
        img.dataset.loading = 'true';
        processedImages.add(img);
        
        // Create a new image to preload
        const preloadImg = new Image();
        
        preloadImg.onload = function() {
            // Smooth fade transition when swapping
            // First set opacity to 0 for fade in
            img.style.opacity = '0';
            
            // Force reflow to ensure opacity 0 is applied
            img.offsetHeight;
            
            // Change the source and then fade in
            requestAnimationFrame(function() {
                img.src = actualSrc;
                img.style.objectFit = 'cover';
                img.style.height = '250px';
                img.style.width = '100%';
                
                // Small delay to ensure image loads, then fade in
                setTimeout(function() {
                    img.style.opacity = '1';
                    img.classList.add('loaded');
                    img.removeAttribute('data-src');
                    img.removeAttribute('data-loading');
                }, 10);
            });
        };
        
        preloadImg.onerror = function() {
            img.classList.add('error');
            img.removeAttribute('data-loading');
        };
        
        // Start loading the actual image
        preloadImg.src = actualSrc;
    }
    
    function loadVisibleImages() {
        // Load all currently visible images immediately
        const allImages = document.querySelectorAll('.product__card--image[data-src]:not([data-loading])');
        const visibleImages = Array.from(allImages).filter(function(img) {
            return isElementVisible(img);
        });
        
        // Load visible images immediately
        visibleImages.forEach(function(img) {
            loadImage(img);
        });
        
        return allImages;
    }
    
    function initializeImageObserver() {
        // Use Intersection Observer for lazy loading - preload much earlier
        if ('IntersectionObserver' in window) {
            imageObserver = new IntersectionObserver(function(entries) {
                // Batch process all intersecting entries together
                const toLoad = [];
                
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        imageObserver.unobserve(entry.target);
                        toLoad.push(entry.target);
                    }
                });
                
                // Load all at once to prevent flashing
                toLoad.forEach(function(img) {
                    loadImage(img);
                });
            }, {
                rootMargin: '300px', // Start loading 300px before image comes into view
                threshold: [0, 0.1, 0.5] // Multiple thresholds for better detection
            });
        }
    }
    
    function observeImages() {
        const allImages = loadVisibleImages();
        
        // Observe remaining images for lazy loading
        allImages.forEach(function(img) {
            if (!img.dataset.loading && imageObserver) {
                imageObserver.observe(img);
            }
        });
    }
    
    function debouncedObserve() {
        // Debounce to prevent excessive calls
        clearTimeout(checkTimeout);
        checkTimeout = setTimeout(function() {
            if (window.requestIdleCallback) {
                requestIdleCallback(observeImages, { timeout: 500 });
            } else {
                observeImages();
            }
        }, 50);
    }
    
    // Initialize when DOM is ready
    function init() {
        initializeImageObserver();
        
        // Load visible images immediately
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', function() {
                observeImages();
                // Also check after a short delay to catch Swiper initialized slides
                setTimeout(observeImages, 300);
            });
        } else {
            observeImages();
            setTimeout(observeImages, 300);
        }
        
        // Optimized MutationObserver - only watch specific containers
        if (mutationObserver) {
            mutationObserver.disconnect();
        }
        
        mutationObserver = new MutationObserver(function(mutations) {
            let hasNewImages = false;
            
            mutations.forEach(function(mutation) {
                mutation.addedNodes.forEach(function(node) {
                    if (node.nodeType === 1) { // Element node
                        // Check if it's a product slide or contains one
                        if (node.classList && (node.classList.contains('swiper-slide') || 
                            node.classList.contains('product__card') || 
                            (node.querySelector && node.querySelector('.product__card--image[data-src]')))) {
                            hasNewImages = true;
                        }
                    }
                });
            });
            
            if (hasNewImages) {
                debouncedObserve();
            }
        });
        
        // Only observe product containers, not the entire body
        const productContainers = document.querySelectorAll('.product__section--inner, .swiper-wrapper');
        productContainers.forEach(function(container) {
            mutationObserver.observe(container, {
                childList: true,
                subtree: true
            });
        });
        
        // Also observe on scroll for any missed images
        let scrollTimeout = null;
        window.addEventListener('scroll', function() {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(function() {
                loadVisibleImages();
            }, 100);
        }, { passive: true });
    }
    
    init();
})();
