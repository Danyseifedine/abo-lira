<script setup lang="ts">
import DataTable from '@/common/components/dashboards/datatable/Datatable.vue';
import DashboardDeleteDialog from '@/common/components/dashboards/datatable/datatableDeleteDialog.vue';
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import DashboardDatePicker from '@/common/components/dashboards/form/DashboardDatePicker.vue';
import DashboardSelect from '@/common/components/dashboards/form/DashboardSelect.vue';
import { useFilters } from '@/core/composables/useFilters';
import { useToast } from '@/core/composables/useToast';
import { formatDateForBackend } from '@/core/utils/formatters';
import { parseDate } from '@/core/utils/parsers';
import { __ } from '@/core/utils/translations';
import type { BreadcrumbItem } from '@core/types';
import type { DataTablePageProps } from '@core/types/datatable';
import { Head, router, usePage } from '@inertiajs/vue3';
import { useDeleteDialog } from '@modules/admin/composables/useDeleteDialog';
import AdminLayout from '@modules/admin/layouts/AdminLayout.vue';
import { Tag } from '@ui/badge';
import { Button } from '@ui/button';
import { Plus } from 'lucide-vue-next';
import { onMounted, watch } from 'vue';
import { createProductColumns } from './datatable/productColumns';
import type { Product } from './datatable/type';

const page = usePage();

interface ProductCategory {
    id: number;
    name_en: string;
    name_ar: string;
}

interface ProductQuality {
    id: number;
    name_en: string;
    name_ar: string;
}

// Product-specific filters interface
interface ProductFilters {
    status?: string;
    category_id?: number;
    quality_id?: number;
    has_variants?: string;
    is_new?: string;
    created_from?: Date | string | null;
    created_to?: Date | string | null;
}

// Props
const props = defineProps<{
    products: DataTablePageProps<Product, ProductFilters>['data'];
    filters: DataTablePageProps<Product, ProductFilters>['filters'];
    columnLabels: {
        number: string;
        name_en: string;
        name_ar: string;
        category: string;
        quality: string;
        price: string;
        stock: string;
        active: string;
        is_new: string;
        out_of_stock: string;
    };
    categories: ProductCategory[];
    qualities: ProductQuality[];
}>();

// Initialize filters from URL params
const initializeFilters = () => {
    const urlFilters = props.filters as any;

    return {
        ...urlFilters,
        status: urlFilters?.status || '',
        category_id: urlFilters?.category_id || null,
        quality_id: urlFilters?.quality_id || null,
        has_variants: urlFilters?.has_variants || '',
        is_new: urlFilters?.is_new || '',
        created_from: parseDate(urlFilters?.created_from),
        created_to: parseDate(urlFilters?.created_to),
    };
};

// Use the reusable filter composable
const { localFilters, isFilteringLoading, hasActiveFilters, activeFilterCount, applyFilters, clearFilters, updateFilters } = useFilters(
    initializeFilters(),
    {
        routeName: 'super-admin.products.index',
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

// Filter options
const statusOptions = [
    { name: __('datatable.active'), code: 'active' },
    { name: __('datatable.inactive'), code: 'inactive' },
];

const hasVariantsOptions = [
    { name: __('datatable.yes'), code: 'yes' },
    { name: __('datatable.no'), code: 'no' },
];

const isNewOptions = [
    { name: __('datatable.yes'), code: 'yes' },
    { name: __('datatable.no'), code: 'no' },
];

// Custom filter logic for date formatting
const applyFiltersWithDateFormat = () => {
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
    pagination: props.products,
    filterable: true,
    filters: {
        ...props.filters,
        direction: props.filters.direction as 'asc' | 'desc' | undefined,
    },
    routeName: 'super-admin.products.index',
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
        title: __('sidebar.products'),
        href: route('super-admin.products.index'),
    },
];

// Delete dialog using composable
const { deleteDialogOpen, itemToDelete: productToDelete, openDeleteDialog } = useDeleteDialog<Product>();

// Create columns with delete dialog function passed as parameter
const productColumns = createProductColumns(openDeleteDialog, props.columnLabels);
</script>

<template>
    <AdminLayout :breadcrumbs="breadcrumbs">
        <Head :title="__('sidebar.products')" />

        <div class="p-4">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">{{ __('datatable.products.title') }}</h1>
                    <p class="mt-1 text-muted-foreground">{{ __('datatable.products.description') }}</p>
                </div>
                <div class="flex gap-2">
                    <!-- <DashboardButton variant="default" @click="() => router.get(route('super-admin.products.create'))">
                        <Plus class="mr-2 h-4 w-4" />
                        {{ __('datatable.add_simple_product') }}
                    </DashboardButton> -->
                    <DashboardButton variant="outline" @click="() => router.get(route('super-admin.products.create-complex'))">
                        <Plus class="mr-2 h-4 w-4" />
                        {{ __('datatable.add_complex_product') }}
                    </DashboardButton>
                </div>
            </div>

            <DataTable :columns="productColumns" :data="products.data" :config="tableConfig" @selection-change="handleSelectionChange">
                <template #toolbar="{ table }">
                    <!-- Active filters display -->
                    <div v-if="hasActiveFilters" class="flex items-center gap-2">
                        <Tag
                            :value="`${activeFilterCount} ${activeFilterCount === 1 ? __('datatable.filter') : __('datatable.filters')} ${__('datatable.applied')}`"
                            severity="info"
                        />
                    </div>

                    <!-- Bulk actions -->
                    <Button v-if="table.getFilteredSelectedRowModel().rows.length > 0" variant="destructive" size="sm">
                        {{ __('datatable.delete') }} ({{ table.getFilteredSelectedRowModel().rows.length }})
                    </Button>
                </template>

                <template #filters>
                    <div class="space-y-4">
                        <!-- Filter Grid -->
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-5">
                            <!-- Status Filter -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium">{{ __('datatable.status') }}</label>
                                <DashboardSelect
                                    v-model="localFilters.status"
                                    :options="statusOptions"
                                    optionLabel="name"
                                    optionValue="code"
                                    :placeholder="__('datatable.all_status')"
                                    class="w-full"
                                    size="small"
                                    :showClear="true"
                                />
                            </div>

                            <!-- Category Filter -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium">{{ __('datatable.category') }}</label>
                                <DashboardSelect
                                    v-model="localFilters.category_id"
                                    :options="categories"
                                    :optionLabel="page.props.locale === 'ar' ? 'name_ar' : 'name_en'"
                                    optionValue="id"
                                    :placeholder="__('datatable.all_categories')"
                                    class="w-full"
                                    size="small"
                                    :showClear="true"
                                    filter
                                    :filterPlaceholder="__('datatable.search')"
                                />
                            </div>

                            <!-- Quality Filter -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium">{{ __('datatable.quality') }}</label>
                                <DashboardSelect
                                    v-model="localFilters.quality_id"
                                    :options="qualities"
                                    :optionLabel="page.props.locale === 'ar' ? 'name_ar' : 'name_en'"
                                    optionValue="id"
                                    :placeholder="__('datatable.all_qualities')"
                                    class="w-full"
                                    size="small"
                                    :showClear="true"
                                    filter
                                    :filterPlaceholder="__('datatable.search')"
                                />
                            </div>

                            <!-- Has Variants Filter -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium">{{ __('datatable.has_variants') }}</label>
                                <DashboardSelect
                                    v-model="localFilters.has_variants"
                                    :options="hasVariantsOptions"
                                    optionLabel="name"
                                    optionValue="code"
                                    :placeholder="__('datatable.all')"
                                    class="w-full"
                                    size="small"
                                    :showClear="true"
                                />
                            </div>

                            <!-- Is New Filter -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium">{{ __('datatable.is_new') }}</label>
                                <DashboardSelect
                                    v-model="localFilters.is_new"
                                    :options="isNewOptions"
                                    optionLabel="name"
                                    optionValue="code"
                                    :placeholder="__('datatable.all')"
                                    class="w-full"
                                    size="small"
                                    :showClear="true"
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
                :item-id="productToDelete?.id ?? null"
                :item-name="productToDelete?.name_en"
                route-name="super-admin.products.destroy"
                :title="__('datatable.delete')"
                :description="__('datatable.delete_confirmation_text')"
                :confirm-button-text="__('datatable.delete_confirmation_button')"
            />
        </div>
    </AdminLayout>
</template>
