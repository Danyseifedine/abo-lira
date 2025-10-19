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
    role: any;
}>();

const permissions = props.permissions.map((permission: any) => ({
    name: permission.name,
    id: permission.id,
}));

// Form - Initialize with role's existing values
const form = useForm({
    name: props.role.name,
    permissions: props.role.permissions?.map((permission: any) => permission.id) || [],
});

// Submit handler
const submit = () => {
    form.put(route('super-admin.roles.update', props.role.id));
};

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Roles', href: route('super-admin.roles.index') },
    { title: 'Edit Role', href: route('super-admin.roles.edit', props.role.id) },
];
</script>

<template>
    <ActionLayout
        type="edit"
        title="Edit Role"
        description="Fill in the details below to edit the role"
        :breadcrumbs="breadcrumbs"
        :back-href="route('super-admin.roles.index')"
        :show-card="false"
        max-width="full"
        card-title="Role Information"
        card-description="Fill in the details below to edit the role"
    >
        <Head title="Edit Role" />

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
                <DashboardButton @click="submit" :loading="form.processing" variant="default"> Update Role </DashboardButton>
            </div>
        </template>
    </ActionLayout>
</template>
