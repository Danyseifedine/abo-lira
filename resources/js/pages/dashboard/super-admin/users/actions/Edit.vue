<script setup lang="ts">
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import DashboardMultiSelect from '@/common/components/dashboards/form/DashboardMultiSelect.vue';
import DashboardTextInput from '@/common/components/dashboards/form/DashboardTextInput.vue';
import DashboardToggle from '@/common/components/dashboards/form/DashboardToggle.vue';
import Hint from '@/common/components/dashboards/typography/Hint.vue';
import type { BreadcrumbItem } from '@core/types';
import { Head, router, useForm } from '@inertiajs/vue3';
import ActionLayout from '@modules/admin/layouts/ActionLayout.vue';
import InputError from '@shared/components/InputError.vue';
import { Label } from '@ui/label';
import { useGuard } from '@/guard';

const { userIsSuperAdmin } = useGuard();

const props = defineProps<{
    roles: any[];
    permissions: any[];
    user: any;
}>();

const roles = props.roles.map((role: any) => ({
    name: role.name,
    id: role.id,
}));

const permissions = props.permissions.map((permission: any) => ({
    name: permission.name,
    id: permission.id,
}));

// Form - Initialize with user's existing values
const form = useForm({
    name: props.user.name,
    email: props.user.email,
    roles: props.user.roles?.map((role: any) => role.id) || [],
    is_active: Boolean(props.user.is_active),
    permissions: props.user.permissions?.map((permission: any) => permission.id) || [],
});

// Submit handler
const submit = () => {
    form.put(route('super-admin.users.update', props.user.id));
};

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Users', href: route('super-admin.users.index') },
    { title: 'Edit User', href: route('super-admin.users.edit', props.user.id) },
];
</script>

<template>
    <ActionLayout
        type="edit"
        title="Edit User"
        description="Fill in the details below to edit the user account"
        :breadcrumbs="breadcrumbs"
        :back-href="route('super-admin.users.index')"
        :show-card="false"
        max-width="full"
        card-title="User Information"
        card-description="Fill in the details below to edit the user account"
    >
        <Head title="Edit User" />

        <!-- Form -->
        <form @submit.prevent="submit" class="space-y-6">
            <!-- Name & Email -->
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                <!-- Name -->
                <div class="space-y-2">
                    <Label for="name" required>Name</Label>
                    <DashboardTextInput
                        id="name"
                        v-model="form.name"
                        type="text"
                        placeholder="Enter user name"
                        :error="form.errors.name"
                        autofocus
                        required
                    />
                    <InputError :message="form.errors.name" />
                    <Hint text="Enter the user's name." />
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <Label for="email" required>Email</Label>
                    <DashboardTextInput
                        id="email"
                        v-model="form.email"
                        type="email"
                        placeholder="Enter email address"
                        :error="form.errors.email"
                        required
                    />
                    <InputError :message="form.errors.email" />
                    <Hint text="Enter the user's email address." />
                </div>
            </div>

            <!-- Roles - Using MultiSelect for multiple role assignment -->
            <div class="space-y-2">
                <Label for="roles">Roles</Label>
                <DashboardMultiSelect
                    id="roles"
                    v-model="form.roles"
                    :options="roles"
                    option-label="name"
                    option-value="id"
                    placeholder="Select roles"
                    :error="form.errors.roles"
                    filter
                    filter-placeholder="Search roles..."
                    display="chip"
                    :show-toggle-all="false"
                    :max-selected-labels="999"
                    selected-items-label="{0} roles selected"
                />
                <InputError :message="form.errors.roles" />
                <Hint text="Assign one or more roles to this user. Roles determine the user's access level." />
            </div>
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
                    :show-toggle-all="false"
                    :max-selected-labels="999"
                    selected-items-label="{0} permissions selected"
                />
                <InputError :message="form.errors.permissions" />
                <Hint text="Assign one or more permissions to this user. Permissions determine the user's access level." />
            </div>

            <!-- Status Toggle (optional) -->
            <div v-if="!userIsSuperAdmin(user)">
            <div class="space-y-2">
                <Label for="status">Status</Label>
                <DashboardToggle
                    id="status"
                    v-model="form.is_active"
                    :error="form.errors.is_active"
                    :label="form.is_active ? 'Active' : 'Inactive'"
                    :hint="form.is_active ? 'The user account is active.' : 'The user account is inactive.'"
                />
                    <InputError :message="form.errors.is_active" />
                    <Hint text="Set whether the user account is active or inactive." />
                </div>
            </div>
        </form>

        <!-- Footer Actions -->
        <template #footer>
            <div class="flex justify-end gap-2">
                <DashboardButton @click="router.visit(route('super-admin.users.index'))" variant="secondary" :disabled="form.processing">
                    Cancel
                </DashboardButton>
                <DashboardButton @click="submit" :loading="form.processing" variant="default"> Update User </DashboardButton>
            </div>
        </template>
    </ActionLayout>
</template>
