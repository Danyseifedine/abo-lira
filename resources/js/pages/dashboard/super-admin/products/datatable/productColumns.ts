import {
    createColumns,
    counterColumn,
    toggleColumn,
    textColumn,
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
    labels: { number: string; name_en: string; name_ar: string; category: string; quality: string; price: string; stock: string; active: string; is_new: string; out_of_stock: string }
) {
    const { showCopyToClipboardToast } = useToast();
    const isToggleLoading = ref(false);

    return createColumns<Product>([
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

        // Category (English)
        badgeColumn('category.name_en', labels.category, {
            sortable: false,
            className: 'text-start',
            showIf: () => document.dir === 'ltr',
        }),

        // Category (Arabic)
        badgeColumn('category.name_ar', labels.category, {
            sortable: false,
            headerClassName: 'text-start px-0',
            className: 'text-start px-0',
            showIf: () => document.dir === 'rtl',
        }),

        // Quality (English)
        badgeColumn('quality.name_en', labels.quality, {
            sortable: false,
            showIf: () => document.dir === 'ltr',
        }),

        // Quality (Arabic)
        badgeColumn('quality.name_ar', labels.quality, {
            sortable: false,
            className: 'text-start px-0',
            headerClassName: 'text-start px-0',
            showIf: () => document.dir === 'rtl',
        }),

        // Price
        textColumn('price', labels.price, {
            sortable: true,
            className: 'font-medium text-start px-2',
            headerClassName: 'text-start px-0',
        }),

        // Stock
        textColumn('stock_quantity', labels.stock, {
            sortable: true,
            headerClassName: 'text-start px-0',
            className: 'text-start px-3',
        }),

        // Status toggle
        toggleColumn('status', labels.active, {
            headerClassName: 'text-center px-0',

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
        }),

        // Is New toggle
        toggleColumn('is_new', labels.is_new, {
            headerClassName: 'text-center px-0',
            onToggle: (value: boolean, product: Product, control) => {
                router.patch(route('super-admin.products.toggle-is-new', product.id), { is_new: value }, {
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
        }),

        // Out of Stock toggle
        toggleColumn('out_of_stock', labels.out_of_stock, {
            headerClassName: 'text-center px-0',
            onToggle: (value: boolean, product: Product, control) => {
                // Only allow toggle if product doesn't have variants
                if (product.has_variants) {
                    control.revert();
                    return;
                }

                router.patch(route('super-admin.products.toggle-out-of-stock', product.id), { out_of_stock: value }, {
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
            disabled: (product: Product) => {
                return isToggleLoading.value || product.has_variants;
            },
            toggledWhen: (value: any) => {
                return convertToBoolean(value);
            },
            size: 'sm',
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

