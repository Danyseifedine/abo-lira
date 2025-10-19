import { ref, inject, provide, type InjectionKey } from 'vue';

export interface DeleteDialogItem {
    id: number;
    [key: string]: any;
}

/**
 * Injection key for delete dialog
 */
export const DeleteDialogKey: InjectionKey<{
    openDeleteDialog: (item: any) => void;
}> = Symbol('DeleteDialog');

/**
 * Hook for managing delete dialog state
 * Use this in the component that renders the delete dialog
 */
export function useDeleteDialog<T extends DeleteDialogItem>(options?: {
    globalKey?: string;
    provide?: boolean;
}) {
    const deleteDialogOpen = ref(false);
    const itemToDelete = ref<T | null>(null);

    const openDeleteDialog = (item: T) => {
        itemToDelete.value = item;
        deleteDialogOpen.value = true;
    };

    const closeDeleteDialog = () => {
        deleteDialogOpen.value = false;
        itemToDelete.value = null;
    };

    // Provide to child components (recommended approach)
    if (options?.provide !== false) {
        provide(DeleteDialogKey, { openDeleteDialog });
    }

    // Make openDeleteDialog available globally if a key is provided (backward compatibility)
    if (options?.globalKey) {
        (window as any)[options.globalKey] = openDeleteDialog;
    }

    return {
        deleteDialogOpen,
        itemToDelete,
        openDeleteDialog,
        closeDeleteDialog,
    };
}

/**
 * Hook for accessing delete dialog from child components
 * Use this in column definitions or any child component
 */
export function useDeleteDialogTrigger<T extends DeleteDialogItem>() {
    const injected = inject(DeleteDialogKey, null);

    if (!injected) {
        console.warn('DeleteDialog not provided. Make sure to use useDeleteDialog with provide: true in parent component.');
        // Fallback to empty function
        return {
            openDeleteDialog: (item: T) => {
                console.error('Delete dialog not available');
            }
        };
    }

    return {
        openDeleteDialog: injected.openDeleteDialog as (item: T) => void
    };
}

