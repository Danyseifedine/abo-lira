import {
    createColumns,
    counterColumn,
    toggleColumn,
    textColumn,
    dateColumn,
    actionsColumn,
    badgeColumn,
} from '@/common/components/dashboards/datatable/columnDef'
import { Copy, Edit, Trash2 } from 'lucide-vue-next'
import { router } from '@inertiajs/vue3'
import type { Product } from './type'
import { useToast } from '@/core/composables/useToast';
import { convertToBoolean } from '@/core/utils/converters';
import { ref } from 'vue';
import { __ } from '@/core/utils/translations';

/**
 * Factory function to create product table columns
 * @param openDeleteDialog - Function to open delete dialog (passed from parent)
 * @param labels - Translated column labels from backend
 */
export function createProductColumns(
    openDeleteDialog: (product: Product) => void,
    labels: { number: string; sku: string; name_en: string; name_ar: string; category: string; quality: string; price: string; stock: string; active: string; created: string }
) {
    const { showCopyToClipboardToast } = useToast();
    const isToggleLoading = ref(false);

    return createColumns<Product>([
        // Row counter
        counterColumn(labels.number, {
            headerClassName: 'text-start',
            startFrom: 1,
        }),

        // SKU
        textColumn('sku', labels.sku, {
            sortable: true,
            searchable: true,
            className: 'font-mono text-sm text-muted-foreground',
            headerClassName: 'text-start px-0',
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

        // Category
        {
            type: 'custom',
            key: 'category',
            label: labels.category,
            sortable: false,
            headerClassName: 'text-start px-0',
            render: (product: Product) => {
                if (product.category) {
                    const name = document.dir === 'rtl' ? product.category.name_ar : product.category.name_en;
                    return name;
                }
                return '-';
            },
        },

        // Quality
        {
            type: 'custom',
            key: 'quality',
            label: labels.quality,
            sortable: false,
            headerClassName: 'text-start px-0',
            render: (product: Product) => {
                if (product.quality) {
                    const name = document.dir === 'rtl' ? product.quality.name_ar : product.quality.name_en;
                    return name;
                }
                return '-';
            },
        },

        // Price
        {
            type: 'custom',
            key: 'price',
            label: labels.price,
            sortable: true,
            headerClassName: 'text-start px-0',
            render: (product: Product) => {
                if (product.has_variants) {
                    return __('datatable.has_variants');
                }
                return product.price ? `$${Number(product.price).toFixed(2)}` : '-';
            },
        },

        // Stock
        {
            type: 'custom',
            key: 'stock_quantity',
            label: labels.stock,
            sortable: true,
            headerClassName: 'text-start px-0',
            render: (product: Product) => {
                if (product.has_variants) {
                    return __('datatable.has_variants');
                }
                return product.stock_quantity !== null ? product.stock_quantity.toString() : '-';
            },
        },

        // Status toggle
        toggleColumn('status', labels.active, {
            headerClassName: 'text-start px-6',
            onToggle: (value: boolean, product: Product, control) => {
                router.patch(route('super-admin.products.toggle-status', product.id), { status: value }, {
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
                onClick: (product) => {
                    navigator.clipboard.writeText(product.id.toString())
                    showCopyToClipboardToast(__('datatable.product_id'));
                },
            },
            { separator: true, label: __('datatable.separator') },
            {
                label: __('datatable.edit'),
                icon: Edit,
                href: (product) => route('super-admin.products.edit', product.id),
            },
            { separator: true, label: __('datatable.separator') },
            {
                label: __('datatable.delete'),
                icon: Trash2,
                destructive: true,
                onClick: (product) => {
                    openDeleteDialog(product);
                },
            },
        ]),
    ]);
}

