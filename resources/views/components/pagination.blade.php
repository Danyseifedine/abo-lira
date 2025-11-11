@props(['paginator'])

@push('styles')
<style>
    @media only screen and (max-width: 767px) {
        .pagination__area {
            padding: 1rem 0.5rem !important;
        }
        .pagination__list {
            margin-right: 0.4rem !important;
        }
        .pagination__item {
            width: 2.8rem !important;
            height: 2.8rem !important;
            line-height: 2.6rem !important;
            font-size: 1.3rem !important;
        }
    }
    /* RTL support for pagination arrows */
    [dir="rtl"] .pagination__arrow--prev {
        transform: rotate(180deg);
    }
    [dir="rtl"] .pagination__arrow--next {
        transform: rotate(180deg);
    }
</style>
@endpush

@if ($paginator->hasPages())
    <div class="pagination__area">
        <ul class="pagination d-flex align-items-center justify-content-center flex-wrap">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="pagination__list">
                    <span class="pagination__item" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none" class="pagination__arrow pagination__arrow--prev">
                            <path d="M7.5 9L4.5 6L7.5 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </li>
            @else
                <li class="pagination__list">
                    <a class="pagination__item" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none" class="pagination__arrow pagination__arrow--prev">
                            <path d="M7.5 9L4.5 6L7.5 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @php
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();
                $pages = [];
                
                // Show first page
                if ($lastPage > 0) {
                    $pages[] = 1;
                }
                
                // Calculate range around current page
                $start = max(2, $currentPage - 1);
                $end = min($lastPage - 1, $currentPage + 1);
                
                // Add ellipsis after first page if needed
                if ($start > 2) {
                    $pages[] = '...';
                }
                
                // Add pages around current page
                for ($i = $start; $i <= $end; $i++) {
                    if ($i != 1 && $i != $lastPage) {
                        $pages[] = $i;
                    }
                }
                
                // Add ellipsis before last page if needed
                if ($end < $lastPage - 1) {
                    $pages[] = '...';
                }
                
                // Show last page
                if ($lastPage > 1) {
                    $pages[] = $lastPage;
                }
            @endphp

            @foreach ($pages as $page)
                @if ($page === '...')
                    <li class="pagination__list d-none d-md-block">
                        <span class="pagination__item">...</span>
                    </li>
                @elseif ($page == $currentPage)
                    <li class="pagination__list">
                        <span class="pagination__item pagination__item--current" aria-current="page">{{ $page }}</span>
                    </li>
                @else
                    @php
                        // On mobile, only show first, last, and pages adjacent to current
                        $showOnMobile = $page == 1 || $page == $lastPage || abs($page - $currentPage) <= 1;
                    @endphp
                    <li class="pagination__list {{ !$showOnMobile ? 'd-none d-md-block' : '' }}">
                        <a class="pagination__item" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="pagination__list">
                    <a class="pagination__item" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none" class="pagination__arrow pagination__arrow--next">
                            <path d="M4.5 9L7.5 6L4.5 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                </li>
            @else
                <li class="pagination__list">
                    <span class="pagination__item" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none" class="pagination__arrow pagination__arrow--next">
                            <path d="M4.5 9L7.5 6L4.5 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </li>
            @endif
        </ul>
    </div>
@endif

