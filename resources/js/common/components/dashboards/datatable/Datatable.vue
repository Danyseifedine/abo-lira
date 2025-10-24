<script setup lang="ts" generic="TData">
import { useDataTable } from '@/core/composables/useDatatable';
import { __ } from '@/core/utils/translations';
import type { ColumnDef } from '@tanstack/vue-table';
import { FlexRender } from '@tanstack/vue-table';
import { Button } from '@ui/button';
import { Card } from '@ui/card';
import { Collapsible, CollapsibleContent } from '@ui/collapsible';
import { DropdownMenu, DropdownMenuCheckboxItem, DropdownMenuContent, DropdownMenuTrigger } from '@ui/dropdown-menu';
import { Input } from '@ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@ui/table';
import { ChevronDown, ChevronLeft, ChevronRight, ChevronsLeft, ChevronsRight, Columns, Filter, Search, X } from 'lucide-vue-next';
import { computed, onUnmounted, ref } from 'vue';
import type { DataTableConfig } from './index';

interface Props {
    columns: ColumnDef<TData>[];
    data: TData[];
    config?: DataTableConfig;
}

const props = withDefaults(defineProps<Props>(), {
    config: () => ({
        searchable: true,
        searchPlaceholder: 'Search...',
        selectable: true,
        columnVisibility: true,
        perPageSelector: true,
        perPageOptions: [10, 20, 30, 50, 100],
        serverSide: false,
        preserveState: false,
        preserveScroll: true,
    }),
});

const emit = defineEmits<{
    'update:filters': [filters: any];
    'row-click': [row: TData];
    'selection-change': [rows: TData[]];
}>();

// Filter panel state
const isFilterPanelOpen = ref(false);

// Use composable for table logic
const {
    globalFilter,
    table,
    currentPage,
    pageCount,
    currentPerPage,
    canPreviousPage,
    canNextPage,
    handleSearch,
    handlePerPageChange,
    nextPage,
    previousPage,
    firstPage,
    lastPage,
    cleanup,
} = useDataTable(props, emit);

// Toggle filter panel
const toggleFilterPanel = () => {
    isFilterPanelOpen.value = !isFilterPanelOpen.value;
};

// Cleanup on unmount
onUnmounted(() => {
    cleanup();
});

// Computed properties
const selectedRowsText = computed(() => {
    if (!props.config?.selectable) return '';

    const selectedCount = table.getFilteredSelectedRowModel().rows.length;
    const totalCount = props.config?.pagination?.total || table.getFilteredRowModel().rows.length;

    if (selectedCount === 0) {
        return `${totalCount} ${__('datatable.rows')}`;
    }
    return `${selectedCount} of ${totalCount} ${__('datatable.rows')} selected`;
});

const showPagination = computed(() => {
    const total = props.config?.pagination?.total || props.data.length;
    return total > 0;
});

// Check if any filters are active (you can customize this based on your filter implementation)
const hasActiveFilters = computed(() => {
    // This is a placeholder - you should check actual filter values
    return isFilterPanelOpen.value;
});
</script>

<template>
    <div class="w-full space-y-4">
        <!-- Toolbar -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <!-- Search -->
            <div v-if="config?.searchable" class="flex flex-1 items-center space-x-2">
                <div class="relative w-full sm:w-[250px] lg:w-[350px]">
                    <Search class="absolute left-2 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
                    <Input
                        :model-value="globalFilter"
                        :placeholder="config.searchPlaceholder"
                        class="h-9 pl-8"
                        @update:model-value="(value: string | number) => handleSearch(String(value))"
                    />
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center gap-2">
                <slot name="toolbar" :table="table" />

                <!-- Filter Toggle Button -->
                <Button
                    v-if="config?.filterable"
                    @click="toggleFilterPanel"
                    variant="outline"
                    size="sm"
                    class="filter-button-transition h-8 gap-1"
                    :class="{
                        'border-primary/20 bg-primary/10 text-primary': isFilterPanelOpen,
                        'hover:bg-primary/5': !isFilterPanelOpen,
                    }"
                >
                    <Filter class="h-3.5 w-3.5 transition-all duration-200" :class="{ 'text-primary': isFilterPanelOpen }" />
                    <span class="sr-only transition-colors duration-200 sm:not-sr-only">{{ __('datatable.filter') }}</span>
                    <ChevronDown
                        class="ml-1 h-3 w-3 transition-all duration-300 ease-out"
                        :class="{ 'rotate-180 text-primary': isFilterPanelOpen }"
                    />
                </Button>

                <!-- Per Page Selector -->
                <DropdownMenu v-if="config?.perPageSelector">
                    <DropdownMenuTrigger as-child>
                        <Button variant="outline" size="sm" class="h-8 gap-1">
                            <span class="hidden sm:inline">{{ __('datatable.rows') }}</span>
                            {{ currentPerPage }}
                            <ChevronDown class="h-3.5 w-3.5" />
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end">
                        <DropdownMenuCheckboxItem
                            v-for="pageSize in config.perPageOptions"
                            :key="pageSize"
                            :checked="currentPerPage === pageSize"
                            @select="handlePerPageChange(pageSize)"
                        >
                            {{ pageSize }} {{ __('datatable.per_page') }}
                        </DropdownMenuCheckboxItem>
                    </DropdownMenuContent>
                </DropdownMenu>

                <!-- Column Visibility -->
                <DropdownMenu v-if="config?.columnVisibility">
                    <DropdownMenuTrigger as-child>
                        <Button variant="outline" size="sm" class="h-8 gap-1">
                            <Columns class="h-3.5 w-3.5" />
                            <span class="sr-only">{{ __('datatable.columns') }}</span>
                        </Button>
                    </DropdownMenuTrigger>
                    <DropdownMenuContent align="end" class="w-[150px]">
                        <DropdownMenuCheckboxItem
                            v-for="column in table.getAllColumns().filter((col: any) => col.getCanHide())"
                            :key="column.id"
                            :checked="column.getIsVisible()"
                            @select="column.toggleVisibility(!column.getIsVisible())"
                        >
                            {{ column.columnDef.meta?.label || column.id }}
                        </DropdownMenuCheckboxItem>
                    </DropdownMenuContent>
                </DropdownMenu>
            </div>
        </div>

        <!-- Collapsible Filter Panel -->
        <Collapsible v-if="config?.filterable" v-model:open="isFilterPanelOpen">
            <CollapsibleContent>
                <Card class="border-dashed p-4">
                    <div class="space-y-4">
                        <!-- Filter Header -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <Filter class="h-4 w-4 text-muted-foreground" />
                                <h3 class="font-medium">{{ __('datatable.filters') }}</h3>
                            </div>
                            <Button @click="isFilterPanelOpen = false" variant="ghost" size="icon" class="h-7 w-7">
                                <X class="h-4 w-4" />
                            </Button>
                        </div>

                        <!-- Filter Content -->
                        <div class="pt-2">
                            <slot name="filters" :table="table" />
                        </div>
                    </div>
                </Card>
            </CollapsibleContent>
        </Collapsible>

        <!-- Table -->
        <div class="rounded-md border bg-background">
            <Table>
                <TableHeader>
                    <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                        <TableHead
                            v-for="header in headerGroup.headers"
                            :key="header.id"
                            :class="header.column.columnDef.meta?.headerClassName"
                            :style="{
                                width: header.column.columnDef.meta?.width || undefined,
                            }"
                        >
                            <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header" :props="header.getContext()" />
                        </TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <template v-if="table.getRowModel().rows?.length">
                        <TableRow
                            v-for="row in table.getRowModel().rows"
                            :key="row.id"
                            :data-state="row.getIsSelected() ? 'selected' : undefined"
                            class="cursor-pointer hover:bg-muted/50"
                            @click="emit('row-click', row.original as TData)"
                        >
                            <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id" :class="cell.column.columnDef.meta?.className">
                                <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                            </TableCell>
                        </TableRow>
                    </template>
                    <TableRow v-else>
                        <TableCell :colspan="columns.length" class="h-24 text-center">
                            <slot name="empty"> {{ __('datatable.no_results_found') }} </slot>
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        </div>

        <!-- Footer -->
        <div v-if="showPagination" class="flex flex-col gap-4 px-2 sm:flex-row sm:items-center sm:justify-between">
            <!-- Selection info -->
            <div class="text-sm text-muted-foreground">
                {{ selectedRowsText }}
            </div>

            <!-- Pagination controls -->
            <div class="flex items-center space-x-2 rtl:space-x-reverse">
                <!-- First Page Button -->
                <Button variant="outline" size="icon" class="h-8 w-8" :disabled="!canPreviousPage" @click="firstPage">
                    <ChevronsLeft class="h-4 w-4 rtl:hidden" />
                    <ChevronsRight class="hidden h-4 w-4 rtl:block" />
                    <span class="sr-only">{{ __('datatable.first_page') }}</span>
                </Button>

                <!-- Previous Page Button -->
                <Button variant="outline" size="icon" class="h-8 w-8" :disabled="!canPreviousPage" @click="previousPage">
                    <ChevronLeft class="h-4 w-4 rtl:hidden" />
                    <ChevronRight class="hidden h-4 w-4 rtl:block" />
                    <span class="sr-only">{{ __('datatable.previous_page') }}</span>
                </Button>

                <!-- Page Info -->
                <div class="flex items-center gap-1 px-2">
                    <span class="text-sm font-medium"> {{ __('datatable.page') }} {{ currentPage }} {{ __('datatable.of') }} {{ pageCount }} </span>
                </div>

                <!-- Next Page Button -->
                <Button variant="outline" size="icon" class="h-8 w-8" :disabled="!canNextPage" @click="nextPage">
                    <ChevronRight class="h-4 w-4 rtl:hidden" />
                    <ChevronLeft class="hidden h-4 w-4 rtl:block" />
                    <span class="sr-only">{{ __('datatable.next_page') }}</span>
                </Button>

                <!-- Last Page Button -->
                <Button variant="outline" size="icon" class="h-8 w-8" :disabled="!canNextPage" @click="lastPage">
                    <ChevronsRight class="h-4 w-4 rtl:hidden" />
                    <ChevronsLeft class="hidden h-4 w-4 rtl:block" />
                    <span class="sr-only">{{ __('datatable.last_page') }}</span>
                </Button>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Smooth transitions for DataTable filter section */
.filter-button-transition {
    transition: all 0.15s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Optimized collapsible animations - using transform instead of height for better performance */
[data-state='open'] {
    animation: slideDown 0.15s cubic-bezier(0.4, 0, 0.2, 1);
}

[data-state='closed'] {
    animation: slideUp 0.15s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes slideDown {
    from {
        transform: translateY(-10px);
        opacity: 0;
    }

    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes slideUp {
    from {
        transform: translateY(0);
        opacity: 1;
    }

    to {
        transform: translateY(-10px);
        opacity: 0;
    }
}

/* Optimized filter content transitions */
.collapsible-content {
    transition:
        transform 0.15s cubic-bezier(0.4, 0, 0.2, 1),
        opacity 0.15s cubic-bezier(0.4, 0, 0.2, 1);
    will-change: transform, opacity;
}
</style>
