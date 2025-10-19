import {
    createColumns,
    textColumn,
    badgeColumn,
    dateColumn,
    actionsColumn,
    counterColumn
} from '@/common/components/dashboards/datatable/columnDef'
import { Copy, Eye, Edit, Trash2 } from 'lucide-vue-next'
import type { Role } from './type'
import { useToast } from '@/core/composables/useToast';

/**
 * Factory function to create role table columns
 * @param openDeleteDialog - Function to open delete dialog (passed from parent)
 */
export function createRoleColumns(openDeleteDialog: (role: Role) => void) {
    const { showCopyToClipboardToast } = useToast();

    return createColumns<Role>([
        // Row counter (change to selectColumn() for checkboxes)
        counterColumn('#', {
            startFrom: 1,
        }),

        // Name with custom styling
        textColumn('name', 'Name', {
            sortable: true,
            searchable: true,
            visible: true,
            className: 'font-medium font-bold w-[120px]',
        }),

        // Permissions with badge variants
        badgeColumn('permissions', 'Permissions'),

        // Join date
        dateColumn('created_at', 'Created', {
            relative: true,
        }),

        // Actions menu
        actionsColumn([
            {
                label: 'Copy ID',
                icon: Copy,
                onClick: (role) => {
                    navigator.clipboard.writeText(role.id.toString());
                    showCopyToClipboardToast('Role ID');
                },
            },
            { separator: true, label: 'Separator' },
            {
                label: 'View',
                icon: Eye,
                href: (role) => route('super-admin.roles.show', role.id),
            },
            {
                label: 'Edit',
                icon: Edit,
                href: (role) => route('super-admin.roles.edit', role.id),
            },
            { separator: true, label: 'Separator' },
            {
                label: 'Delete',
                icon: Trash2,
                destructive: true,
                onClick: (role) => {
                    openDeleteDialog(role);
                },
            },
        ]),
    ]);
}

