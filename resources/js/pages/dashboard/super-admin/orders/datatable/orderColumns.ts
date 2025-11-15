import {
    createColumns,
    counterColumn,
    textColumn,
    dateColumn,
    actionsColumn,
    badgeColumn,
} from '@/common/components/dashboards/datatable/columnDef';
import { Copy, Eye, Trash2, RefreshCw } from 'lucide-vue-next';
import type { Order } from './type';
import { useToast } from '@/core/composables/useToast';
import { __ } from '@/core/utils/translations';

/**
 * Factory function to create order table columns
 * @param openDeleteDialog - Function to open delete dialog (passed from parent)
 * @param openStatusChangeDialog - Function to open status change dialog (passed from parent)
 * @param labels - Translated column labels from backend
 */
export function createOrderColumns(
    openDeleteDialog: (order: Order) => void,
    openStatusChangeDialog: (order: Order) => void,
    labels: {
        number: string;
        order_number: string;
        f_name: string;
        l_name: string;
        phone_number: string;
        city: string;
        total_amount: string;
        status: string;
        created: string;
    }
) {
    const { showCopyToClipboardToast } = useToast();


    return createColumns<Order>([
        // Row counter
        counterColumn(labels.number, {
            headerClassName: 'text-start',
            startFrom: 1,
        }),

        // Order Number
        textColumn('order_number', labels.order_number, {
            sortable: true,
            searchable: true,
            visible: true,
            className: 'font-medium text-start font-bold',
            headerClassName: 'text-start px-0',
        }),

        // First Name
        textColumn('f_name', labels.f_name, {
            sortable: true,
            searchable: true,
            className: 'text-start',
            headerClassName: 'text-start px-0',
        }),

        // Last Name
        textColumn('l_name', labels.l_name, {
            sortable: true,
            searchable: true,
            className: 'text-start',
            headerClassName: 'text-start px-0',
        }),

        // Phone Number
        textColumn('phone_number', labels.phone_number, {
            searchable: true,
            className: 'text-start',
            headerClassName: 'text-start px-0',
        }),

        // City
        textColumn('city', labels.city, {
            searchable: true,
            className: 'text-start',
            headerClassName: 'text-start px-0',
        }),

        textColumn('total_amount', labels.total_amount, {
            searchable: true,
            className: 'text-start',
            headerClassName: 'text-start px-0',
        }),

        // Status Badge - using translated status from backend
        badgeColumn('status', labels.status, {
            variants: {
                [__('order.status.pending')]: 'warning',
                [__('order.status.accepted')]: 'info',
                [__('order.status.on_the_way')]: 'default',
                [__('order.status.completed')]: 'success',
                [__('order.status.rejected')]: 'destructive',
                [__('order.status.refunded')]: 'secondary',
            },
            defaultVariant: 'secondary',
            headerClassName: 'text-start',
            className: 'text-start',
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
                onClick: (order) => {
                    navigator.clipboard.writeText(order.id.toString());
                    showCopyToClipboardToast(__('datatable.order_id'));
                },
            },
            { separator: true, label: __('datatable.separator') },
            {
                label: __('datatable.view'),
                icon: Eye,
                href: (order) => route('super-admin.orders.show', order.id),
            },
            { separator: true, label: __('datatable.separator') },
            {
                label: __('datatable.change_status'),
                icon: RefreshCw,
                onClick: (order) => {
                    openStatusChangeDialog(order);
                },
            },
            { separator: true, label: __('datatable.separator') },
            {
                label: __('datatable.delete'),
                icon: Trash2,
                destructive: true,
                onClick: (order) => {
                    openDeleteDialog(order);
                },
            },
        ]),
    ]);
}

