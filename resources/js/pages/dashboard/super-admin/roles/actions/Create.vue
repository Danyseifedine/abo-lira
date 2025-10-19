<script setup lang="ts">
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import DashboardMultiSelect from '@/common/components/dashboards/form/DashboardMultiSelect.vue';
import DashboardTextInput from '@/common/components/dashboards/form/DashboardTextInput.vue';
import Hint from '@/common/components/dashboards/typography/Hint.vue';
import type { BreadcrumbItem } from '@core/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import ActionLayout from '@modules/admin/layouts/ActionLayout.vue';
import InputError from '@shared/components/InputError.vue';
import { Label } from '@ui/label';

const props = defineProps<{
    permissions: any[];
}>();

const permissions = props.permissions.map((permission: any) => ({
    name: permission.name,
    id: permission.id,
}));

// Form - Initialize with empty values
const form = useForm({
    name: '',
    permissions: [] as string[],
});

// Submit handler
const submit = () => {
    form.post(route('super-admin.roles.store'));
};

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Roles', href: route('super-admin.roles.index') },
    { title: 'Create Role', href: route('super-admin.roles.create') },
];
</script>

<template>
    <ActionLayout
        type="create"
        title="Create Role"
        description="Fill in the details below to create a new role"
        :breadcrumbs="breadcrumbs"
        :back-href="route('super-admin.roles.index')"
        :show-card="false"
        max-width="full"
        card-title="Role Information"
        card-description="Fill in the details below to create a new role"
    >
        <Head title="Create Role" />

        <!-- Form -->
        <form @submit.prevent="submit" class="space-y-6">
            <!-- Name -->
            <div class="space-y-2">
                <Label for="name" required>Role Name</Label>
                <DashboardTextInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    placeholder="Enter role name (e.g., admin, editor, viewer)"
                    :error="form.errors.name"
                    autofocus
                    required
                />
                <InputError :message="form.errors.name" />
                <Hint text="Enter a unique name for this role. Use lowercase with hyphens (e.g., content-manager)." />
            </div>

            <!-- Permissions -->
            <div class="space-y-2">
                <Label for="permissions">Permissions</Label>
                <DashboardMultiSelect
                    id="permissions"
                    v-model="form.permissions"
                    :options="permissions"
                    option-label="name"
                    option-value="id"
                    placeholder="Select permissions"
                    :error="form.errors.permissions"
                    filter
                    filter-placeholder="Search permissions..."
                    display="chip"
                    :show-toggle-all="true"
                    :max-selected-labels="999"
                    selected-items-label="{0} permissions selected"
                />
                <InputError :message="form.errors.permissions" />
                <Hint text="Assign permissions to this role. Permissions define what actions users with this role can perform." />
            </div>
        </form>

        <!-- Footer Actions -->
        <template #footer>
            <div class="flex justify-end gap-2">
                <DashboardButton @click="router.visit(route('super-admin.roles.index'))" variant="secondary" :disabled="form.processing">
                    Cancel
                </DashboardButton>
                <DashboardButton @click="submit" :loading="form.processing" variant="default"> Create Role </DashboardButton>
            </div>
        </template>
    </ActionLayout>
</template>
