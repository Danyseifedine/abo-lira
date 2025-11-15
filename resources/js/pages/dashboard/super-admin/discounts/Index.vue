<script setup lang="ts">
import DataTable from '@/common/components/dashboards/datatable/Datatable.vue';
import DashboardDeleteDialog from '@/common/components/dashboards/datatable/datatableDeleteDialog.vue';
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import DashboardDatePicker from '@/common/components/dashboards/form/DashboardDatePicker.vue';
import { useFilters } from '@/core/composables/useFilters';
import { useToast } from '@/core/composables/useToast';
import { formatDateForBackend } from '@/core/utils/formatters';
import { parseDate } from '@/core/utils/parsers';
import { __ } from '@/core/utils/translations';
import type { BreadcrumbItem } from '@core/types';
import type { DataTablePageProps } from '@core/types/datatable';
import { Head, router } from '@inertiajs/vue3';
import { useDeleteDialog } from '@modules/admin/composables/useDeleteDialog';
import AdminLayout from '@modules/admin/layouts/AdminLayout.vue';
import { Tag } from '@ui/badge';
import { Button } from '@ui/button';
import { onMounted, ref, watch } from 'vue';
import { createDiscountColumns } from './datatable/discountColumns';
import type { DiscountProduct } from './datatable/type';

// Discount-specific filters interface
interface DiscountFilters {
    has_limited_time_discount?: string;
    discount_start_from?: Date | string | null;
    discount_start_to?: Date | string | null;
    discount_end_from?: Date | string | null;
    discount_end_to?: Date | string | null;
}

// Props using the reusable DataTablePageProps type
const props = defineProps<{
    discounts: DataTablePageProps<DiscountProduct, DiscountFilters>['data'];
    filters: DataTablePageProps<DiscountProduct, DiscountFilters>['filters'];
    columnLabels: {
        number: string;
        product_name: string;
        discount_price: string;
        discount_start_date: string;
        discount_end_date: string;
    };
}>();

// Initialize filters from URL params
const initializeFilters = () => {
    const urlFilters = props.filters as any;

    return {
        ...urlFilters,
        has_limited_time_discount: urlFilters?.has_limited_time_discount || '',
        discount_start_from: parseDate(urlFilters?.discount_start_from),
        discount_start_to: parseDate(urlFilters?.discount_start_to),
        discount_end_from: parseDate(urlFilters?.discount_end_from),
        discount_end_to: parseDate(urlFilters?.discount_end_to),
    };
};

// Use the reusable filter composable
const { localFilters, isFilteringLoading, hasActiveFilters, activeFilterCount, applyFilters, clearFilters, updateFilters } = useFilters(
    initializeFilters(),
    {
        routeName: 'super-admin.discounts.index',
        preserveState: false,
        preserveScroll: true,
    },
);

watch(
    () => props.filters,
    (newFilters) => {
        if (newFilters) {
            updateFilters(initializeFilters());
        }
    },
    { deep: true },
);

// Custom filter logic for date formatting
const applyFiltersWithDateFormat = () => {
    // Format dates before applying filters
    if (localFilters.value.discount_start_from) {
        localFilters.value.discount_start_from = formatDateForBackend(localFilters.value.discount_start_from);
    }
    if (localFilters.value.discount_start_to) {
        localFilters.value.discount_start_to = formatDateForBackend(localFilters.value.discount_start_to);
    }
    if (localFilters.value.discount_end_from) {
        localFilters.value.discount_end_from = formatDateForBackend(localFilters.value.discount_end_from);
    }
    if (localFilters.value.discount_end_to) {
        localFilters.value.discount_end_to = formatDateForBackend(localFilters.value.discount_end_to);
    }

    applyFilters();
};

// Configure DataTable
const tableConfig = {
    searchable: true,
    searchPlaceholder: __('datatable.search_placeholder'),
    selectable: true,
    columnVisibility: true,
    perPageSelector: true,
    perPageOptions: [10, 25, 50, 100],
    serverSide: true,
    pagination: props.discounts,
    filterable: true,
    filters: {
        ...props.filters,
        direction: props.filters.direction as 'asc' | 'desc' | undefined,
    },
    routeName: 'super-admin.discounts.index',
};

// Handle events
const handleSelectionChange = () => {
    //
};

const { initFlashToasts } = useToast();

onMounted(() => {
    initFlashToasts();
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: __('datatable.discounts.title'),
        href: route('super-admin.discounts.index'),
    },
];

// Delete dialog using composable
const { deleteDialogOpen, itemToDelete: discountToDelete, openDeleteDialog } = useDeleteDialog<DiscountProduct>();

// Create columns with delete dialog function passed as parameter
const discountColumns = createDiscountColumns(openDeleteDialog, props.columnLabels);
</script>

<template>
    <AdminLayout :breadcrumbs="breadcrumbs">
        <Head :title="__('datatable.discounts.title')" />

        <div class="p-4">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">{{ __('datatable.discounts.title') }}</h1>
                </div>
                <DashboardButton @click="router.visit(route('super-admin.discounts.create'))" variant="default">
                    {{ __('datatable.create') }} {{ __('datatable.discount') }}
                </DashboardButton>
            </div>

            <DataTable :columns="discountColumns" :data="discounts.data" :config="tableConfig" @selection-change="handleSelectionChange">
                <template #toolbar="{ table }">
                    <!-- Active filters display -->
                    <div v-if="hasActiveFilters" class="flex items-center gap-2">
                        <Tag :value="`${activeFilterCount} ${activeFilterCount === 1 ? 'filter' : 'filters'} active`" severity="info" />
                    </div>

                    <!-- Bulk actions -->
                    <Button v-if="table.getFilteredSelectedRowModel().rows.length > 0" variant="destructive" size="sm">
                        {{ __('datatable.delete') }} ({{ table.getFilteredSelectedRowModel().rows.length }})
                    </Button>
                </template>

                <template #filters>
                    <div class="space-y-4">
                        <!-- Filter Grid -->
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                            <!-- Has Limited Time Discount Filter -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium">{{ __('datatable.has_limited_time_discount') }}</label>
                                <DashboardSelect
                                    v-model="localFilters.has_limited_time_discount"
                                    :options="[
                                        { value: '1', label: __('datatable.yes') },
                                        { value: '0', label: __('datatable.no') },
                                    ]"
                                    optionLabel="label"
                                    optionValue="value"
                                    :placeholder="__('datatable.all')"
                                    class="w-full"
                                    size="small"
                                    :showClear="true"
                                />
                            </div>

                            <!-- Discount Start From Date -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium">{{ __('datatable.discount_start_from') }}</label>
                                <DashboardDatePicker
                                    v-model="localFilters.discount_start_from"
                                    :placeholder="__('datatable.select_date')"
                                    size="small"
                                    icon-display="input"
                                />
                            </div>

                            <!-- Discount Start To Date -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium">{{ __('datatable.discount_start_to') }}</label>
                                <DashboardDatePicker
                                    v-model="localFilters.discount_start_to"
                                    :placeholder="__('datatable.select_date')"
                                    size="small"
                                    icon-display="input"
                                />
                            </div>

                            <!-- Discount End From Date -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium">{{ __('datatable.discount_end_from') }}</label>
                                <DashboardDatePicker
                                    v-model="localFilters.discount_end_from"
                                    :placeholder="__('datatable.select_date')"
                                    size="small"
                                    icon-display="input"
                                />
                            </div>

                            <!-- Discount End To Date -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium">{{ __('datatable.discount_end_to') }}</label>
                                <DashboardDatePicker
                                    v-model="localFilters.discount_end_to"
                                    :placeholder="__('datatable.select_date')"
                                    size="small"
                                    icon-display="input"
                                />
                            </div>
                        </div>

                        <!-- Filter Actions -->
                        <div class="flex items-center justify-between border-t pt-4">
                            <div class="text-sm text-muted-foreground">
                                <span v-if="hasActiveFilters">
                                    {{ activeFilterCount }} {{ activeFilterCount === 1 ? __('datatable.filter') : __('datatable.filters') }}
                                    {{ __('datatable.applied') }}
                                </span>
                            </div>
                            <div class="flex gap-2">
                                <Button @click="clearFilters" variant="ghost" size="sm" :disabled="!hasActiveFilters || isFilteringLoading">
                                    {{ __('datatable.clear_all') }}
                                </Button>
                                <DashboardButton @click="applyFiltersWithDateFormat" size="sm" variant="default" :loading="isFilteringLoading">{{
                                    __('datatable.filter')
                                }}</DashboardButton>
                            </div>
                        </div>
                    </div>
                </template>
            </DataTable>

            <!-- Delete confirmation dialog -->
            <DashboardDeleteDialog
                v-model:open="deleteDialogOpen"
                :item-id="discountToDelete?.id ?? null"
                :item-name="discountToDelete?.name"
                route-name="super-admin.discounts.destroy"
                :title="__('datatable.delete_confirmation')"
            />
        </div>
    </AdminLayout>
</template>

