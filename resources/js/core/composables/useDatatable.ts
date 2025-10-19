import { ref, computed, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import type {
    ColumnFiltersState,
    SortingState,
    VisibilityState,
    PaginationState
} from '@tanstack/vue-table'
import {
    getCoreRowModel,
    getFilteredRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    useVueTable
} from '@tanstack/vue-table'

export function useDataTable(props: any, emit: any) {
    // Initialize sorting from server filters
    const initSorting = (): SortingState => {
        if (props.config?.filters?.sort) {
            return [{
                id: props.config.filters.sort,
                desc: props.config.filters.direction === 'desc',
            }]
        }
        return []
    }

    // State management
    const sorting = ref<SortingState>(initSorting())
    const columnFilters = ref<ColumnFiltersState>([])
    const columnVisibility = ref<VisibilityState>({})
    const rowSelection = ref({})
    const globalFilter = ref(props.config?.filters?.search || '')

    // ADD THIS: Pagination state for client-side
    const pagination = ref<PaginationState>({
        pageIndex: 0,
        pageSize: props.config?.perPageOptions?.[0] || 10,
    })

    // Debounce timer for search
    let searchTimer: ReturnType<typeof setTimeout> | null = null

    // Update server-side data
    const updateServerData = (params: Record<string, any>) => {
        if (typeof window === 'undefined' || !props.config?.serverSide) return

        const queryParams = {
            ...props.config.filters,
            ...params,
        }

        Object.keys(queryParams).forEach((key) => {
            if (queryParams[key] === '' || queryParams[key] === null || queryParams[key] === undefined) {
                delete queryParams[key]
            }
        })

        emit('update:filters', queryParams)

        if (props.config.routeName && typeof route !== 'undefined') {
            router.get(route(props.config.routeName), queryParams, {
                preserveState: props.config.preserveState ?? false,
                preserveScroll: props.config.preserveScroll ?? true,
                replace: true,
            })
        }
    }

    // Create table instance
    const table = useVueTable({
        data: props.data,
        columns: props.columns,
        state: {
            get sorting() { return sorting.value },
            get columnFilters() { return columnFilters.value },
            get columnVisibility() { return columnVisibility.value },
            get rowSelection() { return rowSelection.value },
            get globalFilter() { return globalFilter.value },
            get pagination() { return pagination.value }, // ADD THIS
        },
        onSortingChange: (updater) => {
            sorting.value = typeof updater === 'function'
                ? updater(sorting.value)
                : updater

            if (props.config?.serverSide && sorting.value.length > 0) {
                const sort = sorting.value[0]
                updateServerData({
                    sort: sort.id,
                    direction: sort.desc ? 'desc' : 'asc',
                })
            }
        },
        onColumnFiltersChange: (updater) => {
            columnFilters.value = typeof updater === 'function'
                ? updater(columnFilters.value)
                : updater
        },
        onColumnVisibilityChange: (updater) => {
            columnVisibility.value = typeof updater === 'function'
                ? updater(columnVisibility.value)
                : updater
        },
        onRowSelectionChange: (updater) => {
            rowSelection.value = typeof updater === 'function'
                ? updater(rowSelection.value)
                : updater

            const selectedRows = table.getFilteredSelectedRowModel().rows.map(row => row.original)
            emit('selection-change', selectedRows)
        },
        onGlobalFilterChange: (updater) => {
            globalFilter.value = typeof updater === 'function'
                ? updater(globalFilter.value)
                : updater
        },
        // ADD THIS: Pagination change handler
        onPaginationChange: (updater) => {
            pagination.value = typeof updater === 'function'
                ? updater(pagination.value)
                : updater
        },
        getCoreRowModel: getCoreRowModel(),
        getPaginationRowModel: getPaginationRowModel(), // CHANGE: Always use this
        getSortedRowModel: getSortedRowModel(), // CHANGE: Always use this
        getFilteredRowModel: getFilteredRowModel(), // CHANGE: Always use this
        manualPagination: !!props.config?.serverSide,
        manualSorting: !!props.config?.serverSide,
        manualFiltering: !!props.config?.serverSide,
        pageCount: props.config?.serverSide ? props.config?.pagination?.last_page : undefined,
    })

    // Search handler with debouncing
    const handleSearch = (value: string) => {
        globalFilter.value = value

        if (props.config?.serverSide) {
            if (searchTimer) clearTimeout(searchTimer)
            searchTimer = setTimeout(() => {
                updateServerData({ search: value, page: 1 })
            }, 300)
        } else {
            table.setGlobalFilter(value)
        }
    }

    // Per page change handler
    const handlePerPageChange = (value: number) => {
        if (props.config?.serverSide) {
            updateServerData({ per_page: value, page: 1 })
        } else {
            table.setPageSize(value)
        }
    }

    // Pagination navigation
    const goToPage = (page: number) => {
        if (props.config?.serverSide) {
            updateServerData({ page })
        } else {
            table.setPageIndex(page - 1)
        }
    }

    const nextPage = () => {
        if (props.config?.serverSide) {
            const pagination = props.config?.pagination
            if (pagination && pagination.current_page < pagination.last_page) {
                goToPage(pagination.current_page + 1)
            }
        } else {
            table.nextPage()
        }
    }

    const previousPage = () => {
        if (props.config?.serverSide) {
            const pagination = props.config?.pagination
            if (pagination && pagination.current_page > 1) {
                goToPage(pagination.current_page - 1)
            }
        } else {
            table.previousPage()
        }
    }

    const firstPage = () => {
        if (props.config?.serverSide) {
            goToPage(1)
        } else {
            table.setPageIndex(0) // FIX: Use 0 for client-side
        }
    }

    const lastPage = () => {
        if (props.config?.serverSide && props.config?.pagination) {
            goToPage(props.config.pagination.last_page)
        } else {
            table.setPageIndex(table.getPageCount() - 1)
        }
    }

    // Computed properties
    const canPreviousPage = computed(() => {
        if (props.config?.serverSide && props.config?.pagination) {
            return props.config.pagination.current_page > 1
        }
        return table.getCanPreviousPage()
    })

    const canNextPage = computed(() => {
        if (props.config?.serverSide && props.config?.pagination) {
            return props.config.pagination.current_page < props.config.pagination.last_page
        }
        return table.getCanNextPage()
    })

    const currentPage = computed(() => {
        if (props.config?.serverSide && props.config?.pagination) {
            return props.config.pagination.current_page
        }
        return table.getState().pagination.pageIndex + 1
    })

    const pageCount = computed(() => {
        if (props.config?.serverSide && props.config?.pagination) {
            return props.config.pagination.last_page
        }
        return table.getPageCount()
    })

    // ADD THIS: Current per page value
    const currentPerPage = computed(() => {
        if (props.config?.serverSide) {
            return props.config?.pagination?.per_page || props.config?.filters?.per_page || 10
        }
        return table.getState().pagination.pageSize
    })

    // Reset selection when data changes
    watch(() => props.data, () => {
        rowSelection.value = {}
    })

    // Cleanup on unmount
    const cleanup = () => {
        if (searchTimer) {
            clearTimeout(searchTimer)
        }
    }

    return {
        sorting,
        columnFilters,
        columnVisibility,
        rowSelection,
        globalFilter,
        table,
        currentPage,
        pageCount,
        currentPerPage, // ADD THIS
        canPreviousPage,
        canNextPage,
        handleSearch,
        handlePerPageChange,
        goToPage,
        nextPage,
        previousPage,
        firstPage,
        lastPage,
        cleanup,
    }
}
