import {
    createColumns,
    textColumn,
    badgeColumn,
    dateColumn,
    counterColumn,
    actionsColumn
} from '@/common/components/dashboards/datatable/columnDef'
import type { Permission } from './type'
import { Copy, Trash2 } from 'lucide-vue-next'
import { useToast } from '@/core/composables/useToast';

/**
 * Factory function to create permission table columns
 * @param openDeleteDialog - Function to open delete dialog (passed from parent)
 */
export function createPermissionColumns(openDeleteDialog: (permission: Permission) => void) {
    const { showCopyToClipboardToast } = useToast();

    return createColumns<Permission>([
        // Row counter (change to selectColumn() for checkboxes)
        counterColumn('#', {
            startFrom: 1,
        }),

        // Name with custom styling
        textColumn('name', 'Permission', {
            sortable: true,
            searchable: true,
            visible: true,
            className: 'font-medium font-bold',
        }),

        // Roles with badge variants
        badgeColumn('roles', 'Roles'),

        // Join date
        dateColumn('created_at', 'Created', {
            relative: true,
        }),

        // Actions menu
        actionsColumn([
            {
                label: 'Copy ID',
                icon: Copy,
                onClick: (permission: Permission) => {
                    navigator.clipboard.writeText(permission.id.toString());
                    showCopyToClipboardToast('Permission ID');
                },
            },
            { separator: true, label: 'Separator' },
            {
                label: 'Delete',
                icon: Trash2,
                destructive: true,
                onClick: (permission: Permission) => {
                    openDeleteDialog(permission);
                },
            },
        ]),
    ]);
}

