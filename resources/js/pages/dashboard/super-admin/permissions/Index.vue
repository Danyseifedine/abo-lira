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
import type { BreadcrumbItem } from '@core/types';
import type { DataTablePageProps } from '@core/types/datatable';
import { Head } from '@inertiajs/vue3';
import { useDeleteDialog } from '@modules/admin/composables/useDeleteDialog';
import AdminLayout from '@modules/admin/layouts/AdminLayout.vue';
import { Tag } from '@ui/badge';
import { Button } from '@ui/button';
import { onMounted, watch } from 'vue';
import { createPermissionColumns } from './datatable/permissionColumns';
import type { Permission } from './datatable/type';

// Permission-specific filters interface
interface PermissionFilters {
    role?: string;
    created_from?: Date | string | null;
    created_to?: Date | string | null;
}

// Props using the reusable DataTablePageProps type
const props = defineProps<{
    permissions: DataTablePageProps<Permission, PermissionFilters>['data'];
    filters: DataTablePageProps<Permission, PermissionFilters>['filters'];
    roles: any[];
}>();

// Initialize filters from URL params
const initializeFilters = () => {
    const urlFilters = props.filters as any;

    return {
        ...urlFilters,
        role: urlFilters?.role ? Number(urlFilters.role) : null,
        created_from: parseDate(urlFilters?.created_from),
        created_to: parseDate(urlFilters?.created_to),
    };
};

// Use the reusable filter composable
const { localFilters, isFilteringLoading, hasActiveFilters, activeFilterCount, applyFilters, clearFilters, updateFilters } = useFilters(
    initializeFilters(),
    {
        routeName: 'super-admin.permissions.index',
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
const roleOptions = props.roles.map((role: any) => ({
    name: role.name,
    id: role.id,
}));

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
    searchPlaceholder: 'Search permissions by name...',
    selectable: true,
    columnVisibility: true,
    perPageSelector: true,
    perPageOptions: [10, 25, 50, 100],
    serverSide: true,
    pagination: props.permissions,
    filterable: true,
    filters: {
        ...props.filters,
        direction: props.filters.direction as 'asc' | 'desc' | undefined,
    },
    routeName: 'super-admin.permissions.index',
};

// Handle events
const handleSelectionChange = () => {
    //
};

const { initFlashToasts } = useToast();

onMounted(() => {
    initFlashToasts();
});

const handleRowClick = () => {
    // Read-only view, no navigation
};

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Permissions',
        href: route('super-admin.permissions.index'),
    },
];

// Delete dialog using composable
const { deleteDialogOpen, itemToDelete, openDeleteDialog } = useDeleteDialog<Permission>();

// Create columns with delete dialog function passed as parameter
const permissionColumns = createPermissionColumns(openDeleteDialog);
</script>

<template>
    <AdminLayout :breadcrumbs="breadcrumbs">
        <Head title="Permissions" />

        <div class="p-4">
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">Permissions</h1>
                    <p class="mt-1 text-muted-foreground">View all system permissions and their assigned roles</p>
                </div>
            </div>

            <DataTable
                :columns="permissionColumns"
                :data="permissions.data"
                :config="tableConfig"
                @selection-change="handleSelectionChange"
                @row-click="handleRowClick"
            >
                <template #toolbar="{ table }">
                    <!-- Active filters display -->
                    <div v-if="hasActiveFilters" class="flex items-center gap-2">
                        <Tag :value="`${activeFilterCount} ${activeFilterCount === 1 ? 'filter' : 'filters'} active`" severity="info" />
                    </div>

                    <!-- Bulk actions -->
                    <Button v-if="table.getFilteredSelectedRowModel().rows.length > 0" variant="secondary" size="sm">
                        Selected ({{ table.getFilteredSelectedRowModel().rows.length }})
                    </Button>
                </template>

                <template #filters>
                    <div class="space-y-4">
                        <!-- Filter Grid -->
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <!-- Role Filter -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium">Filter by Role</label>
                                <DashboardSelect
                                    v-model="localFilters.role"
                                    :options="roleOptions"
                                    optionLabel="name"
                                    optionValue="id"
                                    placeholder="All Roles"
                                    class="w-full"
                                    size="small"
                                    :showClear="true"
                                    filter
                                    filterPlaceholder="Search..."
                                    :scrollHeight="'100px'"
                                />
                            </div>

                            <!-- Created From Date -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium">Created From</label>
                                <DashboardDatePicker
                                    v-model="localFilters.created_from"
                                    placeholder="Select Created From"
                                    size="small"
                                    icon-display="input"
                                />
                            </div>

                            <!-- Created To Date -->
                            <div class="space-y-2">
                                <label class="text-sm font-medium">Created To</label>
                                <DashboardDatePicker
                                    v-model="localFilters.created_to"
                                    placeholder="Select Created To"
                                    size="small"
                                    icon-display="input"
                                />
                            </div>
                        </div>

                        <!-- Filter Actions -->
                        <div class="flex items-center justify-between border-t pt-4">
                            <div class="text-sm text-muted-foreground">
                                <span v-if="hasActiveFilters">
                                    {{ activeFilterCount }} {{ activeFilterCount === 1 ? 'filter' : 'filters' }} applied
                                </span>
                            </div>
                            <div class="flex gap-2">
                                <Button @click="clearFilters" variant="ghost" size="sm" :disabled="!hasActiveFilters || isFilteringLoading">
                                    Clear All
                                </Button>
                                <DashboardButton @click="applyFiltersWithDateFormat" size="sm" variant="default" :loading="isFilteringLoading"
                                    >Filter</DashboardButton
                                >
                            </div>
                        </div>
                    </div>
                </template>
            </DataTable>

            <!-- Delete confirmation dialog -->
            <DashboardDeleteDialog
                v-model:open="deleteDialogOpen"
                :item-id="itemToDelete?.id ?? null"
                :item-name="itemToDelete?.name"
                route-name="super-admin.permissions.destroy"
                title="Delete Permission"
            />
        </div>
    </AdminLayout>
</template>
