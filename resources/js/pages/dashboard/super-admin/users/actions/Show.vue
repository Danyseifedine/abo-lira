<script setup lang="ts">
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import type { BreadcrumbItem } from '@core/types';
import { Head, router } from '@inertiajs/vue3';
import ActionLayout from '@modules/admin/layouts/ActionLayout.vue';
import { Avatar, AvatarFallback, AvatarImage } from '@ui/avatar';
import { Badge } from '@ui/badge';
import { Separator } from '@ui/separator';
import { Calendar, Edit, Mail, Shield } from 'lucide-vue-next';
import type { User } from '../datatable/type';

interface Props {
    user: User;
}

const props = defineProps<Props>();

// Format date helper
const formatDate = (date: string | null) => {
    if (!date) return 'Not verified';
};

// Get user initials
const getInitials = (name: string) => {
    return name
        .split(' ')
        .map((n) => n[0])
        .join('')
        .toUpperCase()
        .slice(0, 2);
};

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Users', href: route('super-admin.users.index') },
    { title: props.user.name, href: route('super-admin.users.show', props.user.id) },
];

</script>

<template>
    <ActionLayout
        type="show"
        :title="user.name"
        description="View user details and manage account"
        :breadcrumbs="breadcrumbs"
        max-width="full"
        :show-card="false"
        :back-href="route('super-admin.users.index')"
    >
        <Head :title="user.name" />

        <!-- User Profile Header -->
        <div class="mb-8 flex items-center gap-6">
            <Avatar class="h-24 w-24">
                <AvatarImage :src="user.avatar_url || ''" :alt="user.name" />
                <AvatarFallback class="text-2xl">{{ getInitials(user.name) }}</AvatarFallback>
            </Avatar>

            <div class="flex-1">
                <h2 class="text-2xl font-bold">{{ user.name }}</h2>
                <div class="mt-2 flex items-center gap-2">
                    <Badge v-if="user.is_active" variant="success">Active</Badge>
                    <Badge v-else variant="destructive">Inactive</Badge>
                    <Badge v-for="role in user.roles" :key="role.id" variant="secondary">{{ role.name }}</Badge>
                </div>
            </div>

            <div class="flex gap-2">
                <DashboardButton variant="outline" @click="router.visit(route('super-admin.users.edit', props.user.id))">
                    <Edit class="mr-2 h-4 w-4" />
                    Edit
                </DashboardButton>
            </div>
        </div>

        <Separator class="my-6" />

        <!-- User Details -->
        <div class="space-y-6">
            <h3 class="text-lg font-semibold">User Information</h3>

            <div class="grid gap-6 md:grid-cols-2">
                <!-- Email -->
                <div class="flex items-start gap-3">
                    <Mail class="mt-1 h-5 w-5 text-muted-foreground" />
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Email</p>
                        <p class="text-base">{{ user.email }}</p>
                    </div>
                </div>

                <!-- Email Verified -->
                <div class="flex items-start gap-3">
                    <Shield class="mt-1 h-5 w-5 text-muted-foreground" />
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Email Verified</p>
                        <p class="text-base">{{ formatDate(user.email_verified_at) }}</p>
                    </div>
                </div>

                <!-- Created At -->
                <div class="flex items-start gap-3">
                    <Calendar class="mt-1 h-5 w-5 text-muted-foreground" />
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Joined</p>
                        <p class="text-base">{{ new Date(user.created_at).toLocaleDateString() }}</p>
                    </div>
                </div>

                <!-- Status -->
                <div class="flex items-start gap-3">
                    <Shield class="mt-1 h-5 w-5 text-muted-foreground" />
                    <div>
                        <p class="text-sm font-medium text-muted-foreground">Account Status</p>
                        <p class="text-base">{{ user.is_active ? 'Active' : 'Inactive' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <Separator class="my-6" />

        <!-- Roles & Permissions -->
        <div class="space-y-4">
            <h3 class="text-lg font-semibold">Permissions</h3>
            <div class="flex flex-wrap gap-2">
                <Badge v-for="permission in user.permissions" :key="permission.id" variant="outline" class="px-3 py-1 text-sm">
                    {{ permission.name }}
                </Badge>
                <Badge v-if="!user.permissions || user.permissions.length === 0" variant="secondary"> No permissions assigned </Badge>
            </div>
        </div>
    </ActionLayout>
</template>
