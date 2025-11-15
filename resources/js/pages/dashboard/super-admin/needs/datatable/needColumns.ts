import {
    createColumns,
    counterColumn,
    textColumn,
    dateColumn,
    actionsColumn,
    badgeColumn,
    linkColumn,
} from '@/common/components/dashboards/datatable/columnDef';
import { Trash2, Eye } from 'lucide-vue-next';
import type { Need } from './type';
import { __ } from '@/core/utils/translations';

/**
 * Factory function to create need table columns
 * @param openDeleteDialog - Function to open delete dialog (passed from parent)
 * @param labels - Translated column labels from backend
 */
export function createNeedColumns(
    openDeleteDialog: (need: Need) => void,
    labels: {
        number: string;
        f_name: string;
        l_name: string;
        phone_number: string;
        status: string;
        created: string;
    }
) {
    return createColumns<Need>([
        // Row counter
        counterColumn(labels.number, {
            headerClassName: 'text-start',
            startFrom: 1,
        }),

        // First Name
        textColumn('f_name', labels.f_name, {
            sortable: true,
            searchable: true,
            visible: true,
            className: 'font-medium text-start',
            headerClassName: 'text-start',
        }),

        // Last Name
        textColumn('l_name', labels.l_name, {
            sortable: true,
            searchable: true,
            visible: true,
            className: 'font-medium text-start',
            headerClassName: 'text-start',
        }),

        // Phone Number
        textColumn('phone_number', labels.phone_number, {
            sortable: true,
            searchable: true,
            visible: true,
            className: 'text-start font-mono',
            headerClassName: 'text-start',
        }),

        // Status Badge
        badgeColumn('status', labels.status, {
            variants: {
                [__('datatable.unread')]: 'warning',
                [__('datatable.read')]: 'success',
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
                label: __('datatable.view'),
                icon: Eye,
                onClick: (need: Need) => {
                    window.location.href = route('super-admin.needs.show', need.id);
                },
            },
            {
                label: __('datatable.delete'),
                icon: Trash2,
                onClick: (need: Need) => {
                    openDeleteDialog(need);
                },
                variant: 'destructive',
            },
        ]),
    ]);
}

