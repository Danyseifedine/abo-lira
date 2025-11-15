<script setup lang="ts">
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import { __ } from '@/core/utils/translations';
import { useForm } from '@inertiajs/vue3';
import { Button } from '@shared/ui/button';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@shared/ui/dialog';
import { ref, watch } from 'vue';

interface Props {
    open: boolean;
    itemId: number | null;
    itemName?: string;
    routeName: string;
    statusOptions: Array<{ value: string; label: string }>;
    currentStatus?: string;
    title?: string;
    description?: string;
}

const props = withDefaults(defineProps<Props>(), {
    title: 'Change Status',
    description: 'Select a new status for this order.',
});

const emit = defineEmits<{
    (e: 'update:open', value: boolean): void;
}>();

const form = useForm({
    status: '',
});

const selectedStatus = ref<string | null>(null);

watch(
    () => props.open,
    (newValue) => {
        if (newValue) {
            selectedStatus.value = props.currentStatus || null;
            form.status = props.currentStatus || '';
        } else {
            selectedStatus.value = null;
            form.clearErrors();
            form.reset();
        }
    },
);

const changeStatus = () => {
    if (!props.itemId || !selectedStatus.value) {
        return;
    }

    form.status = selectedStatus.value;

    form.patch(route(props.routeName, props.itemId), {
        preserveScroll: false,
        preserveState: false,
        onSuccess: () => {
            emit('update:open', false);
        },
    });
};

const closeModal = () => {
    emit('update:open', false);
};
</script>

<template>
    <Dialog :open="open" @update:open="emit('update:open', $event)">
        <DialogContent>
            <DialogHeader class="space-y-3">
                <DialogTitle>{{ title }}</DialogTitle>
                <DialogDescription>
                    {{ description }}
                    <span v-if="itemName" class="font-semibold text-foreground">{{ itemName }}</span>
                </DialogDescription>
            </DialogHeader>

            <div class="space-y-4 py-4">
                <div class="space-y-2">
                    <label class="text-sm font-medium">{{ __('datatable.status') }}</label>
                    <select
                        v-model="selectedStatus"
                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        <option :value="null" disabled>{{ __('datatable.select_status') }}</option>
                        <option v-for="option in statusOptions" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                    <p v-if="form.errors.status" class="text-sm text-destructive">{{ form.errors.status }}</p>
                </div>
            </div>

            <DialogFooter class="gap-2">
                <DialogClose as-child>
                    <Button variant="secondary" @click="closeModal">{{ __('datatable.cancel') }}</Button>
                </DialogClose>

                <DashboardButton type="button" variant="default" :loading="form.processing" :disabled="!selectedStatus" @click="changeStatus">
                    {{ __('datatable.update_status') }}
                </DashboardButton>
            </DialogFooter>
        </DialogContent>
    </Dialog>
</template>
