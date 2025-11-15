<script setup lang="ts">
import DataTable from '@/common/components/dashboards/datatable/Datatable.vue';
import DashboardDeleteDialog from '@/common/components/dashboards/datatable/datatableDeleteDialog.vue';
import DashboardStatusChangeDialog from '@/common/components/dashboards/datatable/datatableStatusChangeDialog.vue';
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import DashboardDatePicker from '@/common/components/dashboards/form/DashboardDatePicker.vue';
import DashboardSelect from '@/common/components/dashboards/form/DashboardSelect.vue';
import DashboardTextInput from '@/common/components/dashboards/form/DashboardTextInput.vue';
import { useFilters } from '@/core/composables/useFilters';
import { useToast } from '@/core/composables/useToast';
import { formatDateForBackend } from '@/core/utils/formatters';
import { parseDate } from '@/core/utils/parsers';
import { __ } from '@/core/utils/translations';
import type { BreadcrumbItem } from '@core/types';
import type { DataTablePageProps } from '@core/types/datatable';
import { Head } from '@inertiajs/vue3';
import { useDeleteDialog } from '@modules/admin/composables/useDeleteDialog';
import AdminLayout from '@modules/admin/layouts/AdminLayout.vue';
import { Tag } from '@ui/badge';
import { Button } from '@ui/button';
import { onMounted, ref, watch } from 'vue';
import { createOrderColumns } from './datatable/orderColumns';
import type { Order } from './datatable/type';

// Order-specific filters interface
interface OrderFilters {
    status?: string;
    created_from?: Date | string | null;
    created_to?: Date | string | null;
    min_amount?: string | number;
    max_amount?: string | number;
}

// Props using the reusable DataTablePageProps type
const props = defineProps<{
    orders: DataTablePageProps<Order, OrderFilters>['data'];
    filters: DataTablePageProps<Order, OrderFilters>['filters'];
    columnLabels: {
        number: string;
        order_number: string;
        f_name: string;
        l_name: string;
        phone_number: string;
        city: string;
        total_amount: string;
        status: string;
        created: string;
    };
    statusOptions: Array<{ value: string; label: string }>;
}>();

// Initialize filters from URL params
const initializeFilters = () => {
    const urlFilters = props.filters as any;

    return {
        ...urlFilters,
        status: urlFilters?.status || '',
        created_from: parseDate(urlFilters?.created_from),
        created_to: parseDate(urlFilters?.created_to),
        min_amount: urlFilters?.min_amount || '',
        max_amount: urlFilters?.max_amount || '',
    };
};

// Use the reusable filter composable
const { localFilters, isFilteringLoading, hasActiveFilters, activeFilterCount, applyFilters, clearFilters, updateFilters } = useFilters(
    initializeFilters(),
    {
        routeName: 'super-admin.orders.index',
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
    if (localFilters.value.created_from) {
        localFilters.value.created_from = formatDateForBackend(localFilters.value.created_from);
    }
    if (localFilters.value.created_to) {
        localFilters.value.created_to = formatDateForBackend(localFilters.value.created_to);
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
    pagination: props.orders,
    filterable: true,
    filters: {
        ...props.filters,
        direction: props.filters.direction as 'asc' | 'desc' | undefined,
    },
    routeName: 'super-admin.orders.index',
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
        title: __('datatable.orders.title'),
        href: route('super-admin.orders.index'),
    },
];

// Delete dialog using composable
const { deleteDialogOpen, itemToDelete: orderToDelete, openDeleteDialog } = useDeleteDialog<Order>();

// Status change dialog
const statusChangeDialogOpen = ref(false);
const orderToChangeStatus = ref<Order | null>(null);

const openStatusChangeDialog = (order: Order) => {
    orderToChangeStatus.value = order;
    statusChangeDialogOpen.value = true;
};

// Create columns with delete dialog and status change dialog functions passed as parameters
const orderColumns = createOrderColumns(openDeleteDialog, openStatusChangeDialog, props.columnLabels);
</script>

<template>
    <AdminLayout :breadcrumbs="breadcrumbs">
        <Head :title="__('datatable.orders.title')" />

        <div class="p-4">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">{{ __('datatable.orders.title') }}</h1>
                </div>
            </div>

            <DataTable :columns="orderColumns" :data="orders.data" :config="tableConfig" @selection-change="handleSelectionChange">
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
                            <!-- Status Filter -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium">{{ __('datatable.status') }}</label>
                                <DashboardSelect
                                    v-model="localFilters.status"
                                    :options="statusOptions"
                                    optionLabel="label"
                                    optionValue="value"
                                    :placeholder="__('datatable.all_status')"
                                    class="w-full"
                                    size="small"
                                    :showClear="true"
                                    filter
                                    :filterPlaceholder="__('datatable.search') + '...'"
                                    :scrollHeight="'200px'"
                                />
                            </div>

                            <!-- Created From Date -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium">{{ __('datatable.created_from') }}</label>
                                <DashboardDatePicker
                                    v-model="localFilters.created_from"
                                    :placeholder="__('datatable.select_created_from')"
                                    size="small"
                                    icon-display="input"
                                />
                            </div>

                            <!-- Created To Date -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium">{{ __('datatable.created_to') }}</label>
                                <DashboardDatePicker
                                    v-model="localFilters.created_to"
                                    :placeholder="__('datatable.select_created_to')"
                                    size="small"
                                    icon-display="input"
                                />
                            </div>

                            <!-- Min Amount Filter -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium">{{ __('datatable.min_amount') }}</label>
                                <DashboardTextInput
                                    v-model="localFilters.min_amount"
                                    type="number"
                                    step="0.01"
                                    :placeholder="__('datatable.min_amount')"
                                />
                            </div>

                            <!-- Max Amount Filter -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium">{{ __('datatable.max_amount') }}</label>
                                <DashboardTextInput
                                    v-model="localFilters.max_amount"
                                    type="number"
                                    step="0.01"
                                    :placeholder="__('datatable.max_amount')"
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
                :item-id="orderToDelete?.id ?? null"
                :item-name="orderToDelete?.order_number"
                route-name="super-admin.orders.destroy"
                :title="__('datatable.delete_confirmation')"
            />

            <!-- Status change dialog -->
            <DashboardStatusChangeDialog
                v-model:open="statusChangeDialogOpen"
                :item-id="orderToChangeStatus?.id ?? null"
                :item-name="orderToChangeStatus?.order_number"
                route-name="super-admin.orders.change-status"
                :status-options="statusOptions"
                :current-status="orderToChangeStatus?.status_raw"
                :title="__('datatable.change_status')"
                :description="__('datatable.change_status_description')"
            />
        </div>
    </AdminLayout>
</template>
