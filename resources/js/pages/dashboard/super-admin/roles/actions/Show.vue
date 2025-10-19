<script setup lang="ts">
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import type { BreadcrumbItem } from '@core/types';
import { Head, router } from '@inertiajs/vue3';
import ActionLayout from '@modules/admin/layouts/ActionLayout.vue';
import { Badge } from '@ui/badge';
import { Separator } from '@ui/separator';
import { Calendar, Edit, Shield } from 'lucide-vue-next';
import type { Role } from '../datatable/type';

interface Props {
    role: Role;
}

const props = defineProps<Props>();

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Roles', href: route('super-admin.roles.index') },
    { title: props.role.name, href: route('super-admin.roles.show', props.role.id) },
];
</script>

<template>
    <ActionLayout
        type="show"
        :title="role.name"
        description="View role details and manage permissions"
        :breadcrumbs="breadcrumbs"
        max-width="full"
        :show-card="false"
        :back-href="route('super-admin.roles.index')"
    >
        <Head :title="role.name" />

        <!-- Role Header -->
        <div class="mb-8 flex items-center justify-between">
            <div class="flex-1">
                <h2 class="text-2xl font-bold capitalize">{{ role.name }}</h2>
                <div class="mt-2 flex items-center gap-2">
                    <Badge variant="secondary">{{ role.permissions?.length || 0 }} permissions</Badge>
                </div>
            </div>

            <div class="flex gap-2">
                <DashboardButton variant="outline" @click="router.visit(route('super-admin.roles.edit', props.role.id))">
                    <Edit class="mr-2 h-4 w-4" />
                    Edit
                </DashboardButton>
            </div>
        </div>

        <Separator class="my-6" />

        <!-- Role Details -->
        <div class="space-y-6">
            <h3 class="text-lg font-semibold">Role Information</h3>

            <div class="grid gap-6 md:grid-cols-2">
                <!-- Role Name -->
                <div class="flex items-start gap-3">
                    <Shield class="mt-1 h-5 w-5 text-muted-foreground" />
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Role Name</p>
                        <p class="text-base capitalize">{{ role.name }}</p>
                    </div>
                </div>

                <!-- Created At -->
                <div class="flex items-start gap-3">
                    <Calendar class="mt-1 h-5 w-5 text-muted-foreground" />
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Created</p>
                        <p class="text-base">{{ new Date(role.created_at).toLocaleDateString() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <Separator class="my-6" />

        <!-- Permissions -->
        <div class="space-y-4">
            <h3 class="text-lg font-semibold">Permissions</h3>
            <div class="flex flex-wrap gap-2">
                <Badge v-for="permission in role.permissions" :key="permission.id" variant="outline" class="px-3 py-1 text-sm">
                    {{ permission.name }}
                </Badge>
                <Badge v-if="!role.permissions || role.permissions.length === 0" variant="secondary"> No permissions assigned </Badge>
            </div>
        </div>
    </ActionLayout>
</template>
