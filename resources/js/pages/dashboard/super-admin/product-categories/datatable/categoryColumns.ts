import {
    createColumns,
    counterColumn,
    toggleColumn,
    textColumn,
    dateColumn,
    actionsColumn,
} from '@/common/components/dashboards/datatable/columnDef'
import { Copy, Edit, Trash2 } from 'lucide-vue-next'
import { router } from '@inertiajs/vue3'
import type { ProductCategory } from './type'
import { useToast } from '@/core/composables/useToast';
import { convertToBoolean } from '@/core/utils/converters';
import { ref } from 'vue';
import { __ } from '@/core/utils/translations';

/**
 * Factory function to create product category table columns
 * @param openDeleteDialog - Function to open delete dialog (passed from parent)
 * @param labels - Translated column labels from backend
 */
export function createCategoryColumns(
    openDeleteDialog: (category: ProductCategory) => void,
    labels: { number: string; name_en: string; name_ar: string; parent: string; slug: string; active: string; created: string }
) {
    const { showCopyToClipboardToast } = useToast();
    const isToggleLoading = ref(false);

    return createColumns<ProductCategory>([
        // Row counter
        counterColumn(labels.number, {
            headerClassName: 'text-start',
            startFrom: 1,
        }),

        // English Name
        textColumn('name_en', labels.name_en, {
            sortable: true,
            searchable: true,
            visible: true,
            className: 'font-medium font-bold',
            headerClassName: 'text-start px-0',
            showIf: () => document.dir === 'ltr',
        }),

        // Arabic Name
        textColumn('name_ar', labels.name_ar, {
            sortable: true,
            searchable: true,
            className: 'font-arabic text-start',
            headerClassName: 'text-start px-0',
            showIf: () => document.dir === 'rtl',
        }),

        // Parent Category
        {
            type: 'custom',
            key: 'parent',
            label: labels.parent,
            sortable: false,
            headerClassName: 'text-start px-0',
            render: (category: ProductCategory) => {
                if (category.parent) {
                    const name = document.dir === 'rtl' ? category.parent.name_ar : category.parent.name_en;
                    return name;
                }
                return '-';
            },
        },

        // Slug
        textColumn('slug', labels.slug, {
            sortable: true,
            searchable: true,
            className: 'text-muted-foreground font-mono text-sm',
            headerClassName: 'text-start px-0',
        }),

        // Status toggle
        toggleColumn('status', labels.active, {
            headerClassName: 'text-start px-6',
            onToggle: (value: boolean, category: ProductCategory, control) => {
                router.patch(route('super-admin.product-categories.toggle-status', category.id), { status: value }, {
                    preserveScroll: true,
                    preserveState: true,
                    onStart: () => {
                        isToggleLoading.value = true;
                    },
                    onFinish: () => {
                        isToggleLoading.value = false;
                    },
                    onSuccess: (page) => {
                        const response = (page.props as any).flash?.toast;
                        if (response?.success === false) {
                            control.revert();
                        }
                    }
                });
            },
            disabled: () => {
                return isToggleLoading.value;
            },
            toggledWhen: (value: any) => {
                return convertToBoolean(value);
            },
            size: 'sm',
            className: 'flex justify-start',
        }),

        // Created date
        dateColumn('created_at', labels.created, {
            relative: true,
            className: 'text-center',
            headerClassName: 'text-center px-0',
        }),

        // Actions menu
        actionsColumn([
            {
                label: __('datatable.copy_id'),
                icon: Copy,
                onClick: (category) => {
                    navigator.clipboard.writeText(category.id.toString())
                    showCopyToClipboardToast(__('datatable.category_id'));
                },
            },
            { separator: true, label: __('datatable.separator') },
            {
                label: __('datatable.edit'),
                icon: Edit,
                href: (category) => route('super-admin.product-categories.edit', category.id),
            },
            { separator: true, label: __('datatable.separator') },
            {
                label: __('datatable.delete'),
                icon: Trash2,
                destructive: true,
                onClick: (category) => {
                    openDeleteDialog(category);
                },
            },
        ]),
    ]);
}


