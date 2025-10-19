import { router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

export interface UseFiltersOptions {
    routeName: string;
    preserveState?: boolean;
    preserveScroll?: boolean;
    onFilterStart?: () => void;
    onFilterEnd?: () => void;
}

export function useFilters(
    initialFilters: Record<string, any>,
    options: UseFiltersOptions
) {
    // Reactive filter state
    const localFilters = ref({ ...initialFilters });
    const isFilteringLoading = ref(false);

    // Watch for prop changes and update local filters
    const updateFilters = (newFilters: Record<string, any>) => {
        localFilters.value = { ...newFilters };
    };

    // Check if filters are active
    const hasActiveFilters = computed(() => {
        return Object.entries(localFilters.value).some(([key, value]) => {
            if (key === 'search' || key === 'sort' || key === 'direction' || key === 'per_page') {
                return false; // Don't count default table params as active filters
            }

            if (Array.isArray(value)) {
                return value.length > 0;
            }

            if (value instanceof Date) {
                return value !== null;
            }

            return value !== '' && value !== null && value !== undefined;
        });
    });

    // Count active filters
    const activeFilterCount = computed(() => {
        return Object.entries(localFilters.value).filter(([key, value]) => {
            if (key === 'search' || key === 'sort' || key === 'direction' || key === 'per_page') {
                return false; // Don't count default table params
            }

            if (Array.isArray(value)) {
                return value.length > 0;
            }

            if (value instanceof Date) {
                return value !== null;
            }

            return value !== '' && value !== null && value !== undefined;
        }).length;
    });

    // Apply filters
    const applyFilters = () => {
        const queryParams = { ...localFilters.value };

        // Remove undefined/null/empty values
        Object.keys(queryParams).forEach(key => {
            const value = queryParams[key];

            if (value === undefined || value === null) {
                delete queryParams[key];
            } else if (value === '') {
                delete queryParams[key];
            } else if (Array.isArray(value) && value.length === 0) {
                delete queryParams[key];
            }
        });

        isFilteringLoading.value = true;
        options.onFilterStart?.();

        router.get(route(options.routeName), queryParams, {
            preserveState: options.preserveState ?? false,
            preserveScroll: options.preserveScroll ?? true,
            replace: true,
            onFinish: () => {
                isFilteringLoading.value = false;
                options.onFilterEnd?.();
            },
        });
    };

    // Clear all filters
    const clearFilters = () => {
        const clearedFilters = { ...localFilters.value };

        Object.keys(clearedFilters).forEach(key => {
            if (key === 'search' || key === 'sort' || key === 'direction' || key === 'per_page') {
                return; // Keep default table params
            }

            const value = clearedFilters[key];

            if (Array.isArray(value)) {
                clearedFilters[key] = [];
            } else if (value instanceof Date) {
                clearedFilters[key] = null;
            } else {
                clearedFilters[key] = '';
            }
        });

        localFilters.value = clearedFilters;
        applyFilters();
    };

    // Reset single filter
    const resetFilter = (key: string) => {
        const value = localFilters.value[key];

        if (Array.isArray(value)) {
            localFilters.value[key] = [];
        } else if (value instanceof Date) {
            localFilters.value[key] = null;
        } else {
            localFilters.value[key] = '';
        }
    };

    return {
        localFilters,
        isFilteringLoading,
        hasActiveFilters,
        activeFilterCount,
        applyFilters,
        clearFilters,
        resetFilter,
        updateFilters,
    };
}
