<script setup lang="ts">
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import { useForm } from '@inertiajs/vue3';
import { Button } from '@shared/ui/button';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@shared/ui/dialog';
import { watch } from 'vue';

interface Props {
    open: boolean;
    itemId: number | null;
    itemName?: string;
    routeName: string;
    title?: string;
    description?: string;
}

const props = withDefaults(defineProps<Props>(), {
    title: 'Delete Item',
    description: 'Are you sure you want to delete this item? This action cannot be undone and all associated data will be permanently removed.',
});

const emit = defineEmits<{
    (e: 'update:open', value: boolean): void;
    (e: 'deleted'): void;
}>();

const form = useForm({});

const deleteItem = () => {
    if (!props.itemId) {
        return;
    }

    form.delete(route(props.routeName, props.itemId), {
        preserveScroll: true,
        preserveState: false,
        onSuccess: () => {
            closeModal();
            emit('deleted');
        },
        onFinish: () => {
            form.reset();
        },
    });
};

const closeModal = () => {
    emit('update:open', false);
    form.clearErrors();
    form.reset();
};

// Close modal when open prop changes to false
watch(
    () => props.open,
    (newValue) => {
        if (!newValue) {
            form.clearErrors();
            form.reset();
        }
    },
);
</script>

<template>
    <Dialog :open="open" @update:open="(value) => emit('update:open', value)">
        <DialogContent>
            <DialogHeader class="space-y-3">
                <DialogTitle>{{ title }}</DialogTitle>
                <DialogDescription>
                    <template v-if="itemName">
                        Are you sure you want to delete <span class="font-semibold text-foreground">{{ itemName }}</span
                        >? This action cannot be undone and all associated data will be permanently removed.
                    </template>
                    <template v-else>
                        {{ description }}
                    </template>
                </DialogDescription>
            </DialogHeader>

            <DialogFooter class="gap-2">
                <DialogClose as-child>
                    <Button variant="secondary" @click="closeModal">Cancel</Button>
                </DialogClose>

                <DashboardButton type="button" variant="destructive" :loading="form.processing" @click="deleteItem"> Delete </DashboardButton>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
