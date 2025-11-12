@props([
'isForMobile' => false,
])

<div class="position-relative">
    <div class="{{ $isForMobile ? 'd-flex align-items-center gap-2 justify-content-between mobile-lang-switcher' : '' }}" style="cursor: pointer;" id="lang-switcher-btn">
        @if($isForMobile)
        <span class="text-base">{{ __('nav.language') }}</span>
        @else
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display: block;">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
            <line x1="2" y1="12" x2="22" y2="12"></line>
        </svg>
        @endif
    </div>

    <div class="dropdown_lang_content p-2">
        <div class="d-flex flex-column gap-2">
            <div href="/en" class="px-5 py-4 lang-link en-lang-link {{ app()->getLocale() === 'en' ? 'active-lang-link' : '' }}">{{ __('nav.english') }}</div>
            <div href="/ar" class="px-5 py-4 lang-link ar-lang-link {{ app()->getLocale() === 'ar' ? 'active-lang-link' : '' }}">{{ __('nav.arabic') }}</div>
        </div>
    </div>
</div>

<style>
    .dropdown_lang_content {
        display: block;
        position: absolute;
        top: 100%;
        right: 0;
        margin-top: 5px;
        background-color: white;
        border: 1px solid var(--border-color);
        border-radius: 5px;
        box-shadow: 0 5px 30px rgba(0, 0, 0, 0.1);
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px) scale(0.95);
        transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s ease;
    }

    [dir="rtl"] .dropdown_lang_content {
        left: 0 !important;
        right: auto !important;
    }

    .dropdown_lang_content.active {
        opacity: 1;
        visibility: visible;
        transform: translateY(0) scale(1);
    }

    .lang-link {
        font-size: 1.3rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .lang-link:hover {
        background: var(--bg-offwhite-color);
    }

    .active-lang-link {
        background: var(--bg-offwhite-color);
        font-weight: bold;
        color: #ED1D24;
    }

    .mobile-lang-switcher {
        z-index: 0;
        width: 100%;
        padding: 10px 15px;
        border: 1px solid var(--border-color);
        border-radius: 5px;
    }
</style>

<script>
    (function() {
        const langSwitcherBtn = document.getElementById('lang-switcher-btn');
        const dropdownContent = document.querySelector('.dropdown_lang_content');
        const langSwitcherContainer = langSwitcherBtn.closest('.position-relative');

        langSwitcherBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdownContent.classList.toggle('active');
        });

        document.addEventListener('click', function(e) {
            if (!langSwitcherContainer.contains(e.target)) {
                dropdownContent.classList.remove('active');
            }
        });

        // Language switching functionality
        function switchLanguage(locale) {
            // Get current path
            const currentPath = window.location.pathname;
            const pathSegments = currentPath.split('/').filter((segment) => segment);

            // Remove current locale from path if it exists
            if (pathSegments.length > 0 && ['en', 'ar'].includes(pathSegments[0])) {
                pathSegments.shift();
            }

            // Build new URL with new locale
            const newPath = `/${locale}/${pathSegments.join('/')}`;
            const newUrl = window.location.search ? `${window.location.origin}${newPath}${window.location.search}` : `${window.location.origin}${newPath}`;

            // Navigate to new URL (this will refresh the page)
            window.location.href = newUrl;
        }

        // Add click handlers to language links
        const enLangLink = document.querySelector('.en-lang-link');
        const arLangLink = document.querySelector('.ar-lang-link');

        if (enLangLink) {
            enLangLink.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                switchLanguage('en');
            });
        }

        if (arLangLink) {
            arLangLink.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                switchLanguage('ar');
            });
        }
    })();
</script>