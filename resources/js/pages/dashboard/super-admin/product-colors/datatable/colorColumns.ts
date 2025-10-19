import {
    createColumns,
    counterColumn,
    toggleColumn,
    textColumn,
    dateColumn,
    actionsColumn,
    colorColumn,
} from '@/common/components/dashboards/datatable/columnDef'
import { Copy, Edit, Trash2 } from 'lucide-vue-next'
import { router } from '@inertiajs/vue3'
import type { ProductColor } from './type'
import { useToast } from '@/core/composables/useToast';
import { convertToBoolean } from '@/core/utils/converters';
import { ref } from 'vue';
import { __ } from '@/core/utils/translations';

/**
 * Factory function to create product color table columns
 * @param openDeleteDialog - Function to open delete dialog (passed from parent)
 * @param labels - Translated column labels from backend
 */
export function createColorColumns(
    openDeleteDialog: (color: ProductColor) => void,
    labels: { number: string; name_en: string; name_ar: string; color: string; active: string; created: string }
) {
    const { showCopyToClipboardToast } = useToast();
    const isToggleLoading = ref(false);

    return createColumns<ProductColor>([
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
            className: 'font-medium text-start font-bold px-0',
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

        // Color Code with visual preview
        colorColumn('code', labels.color, {
            sortable: true,
            searchable: true,
            showCode: true,
            swatchSize: 'lg',
            headerClassName: 'text-start px-0',
        }),

        // Status toggle
        toggleColumn('status', labels.active, {
            headerClassName: 'text-start px-4',
            onToggle: (value: boolean, color: ProductColor, control) => {
                router.patch(route('super-admin.product-colors.toggle-status', color.id), { status: value }, {
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
                onClick: (color) => {
                    navigator.clipboard.writeText(color.id.toString())
                    showCopyToClipboardToast(__('datatable.color_id'));
                },
            },
            { separator: true, label: __('datatable.separator') },
            {
                label: __('datatable.edit'),
                icon: Edit,
                href: (color) => route('super-admin.product-colors.edit', color.id),
            },
            { separator: true, label: __('datatable.separator') },
            {
                label: __('datatable.delete'),
                icon: Trash2,
                destructive: true,
                onClick: (color) => {
                    openDeleteDialog(color);
                },
            },
        ]),
    ]);
}

