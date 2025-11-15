import {
    createColumns,
    counterColumn,
    textColumn,
    dateColumn,
    actionsColumn,
    badgeColumn,
} from '@/common/components/dashboards/datatable/columnDef';
import { Copy, Eye, Edit, Trash2 } from 'lucide-vue-next';
import type { DiscountProduct } from './type';
import { useToast } from '@/core/composables/useToast';
import { __ } from '@/core/utils/translations';

/**
 * Factory function to create discount table columns
 * @param openDeleteDialog - Function to open delete dialog (passed from parent)
 * @param labels - Translated column labels from backend
 */
export function createDiscountColumns(
    openDeleteDialog: (product: DiscountProduct) => void,
    labels: {
        number: string;
        product_name: string;
        discount_price: string;
        discount_start_date: string;
        discount_end_date: string;
    }
) {
    const { showCopyToClipboardToast } = useToast();

    return createColumns<DiscountProduct>([
        // Row counter
        counterColumn(labels.number, {
            headerClassName: 'text-start',
            startFrom: 1,
        }),

        // Product Name
        textColumn('name', labels.product_name, {
            sortable: true,
            searchable: true,
            visible: true,
            className: 'font-medium text-start font-bold',
            headerClassName: 'text-start',
        }),

        // Discount Price
        textColumn('discount_price', labels.discount_price, {
            sortable: true,
            searchable: false,
            visible: true,
            className: 'text-start font-mono font-semibold',
            headerClassName: 'text-start',
            format: (value) => `$${Number(value).toFixed(2)}`,
        }),

        // Discount Start Date
        dateColumn('discount_start_date', labels.discount_start_date, {
            sortable: true,
            className: 'text-center',
            headerClassName: 'text-center',
        }),

        // Discount End Date
        dateColumn('discount_end_date', labels.discount_end_date, {
            sortable: true,
            className: 'text-center',
            headerClassName: 'text-center',
        }),

        // Actions menu
        actionsColumn([
            {
                label: __('datatable.view'),
                icon: Eye,
                onClick: (product: DiscountProduct) => {
                    window.location.href = route('super-admin.discounts.show', product.id);
                },
            },
            {
                label: __('datatable.edit'),
                icon: Edit,
                onClick: (product: DiscountProduct) => {
                    window.location.href = route('super-admin.discounts.edit', product.id);
                },
            },
            {
                label: __('datatable.delete'),
                icon: Trash2,
                onClick: (product: DiscountProduct) => {
                    openDeleteDialog(product);
                },
                variant: 'destructive',
            },
        ]),
    ]);
}

