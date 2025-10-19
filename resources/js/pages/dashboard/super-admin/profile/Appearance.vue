<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import { type BreadcrumbItem } from '@core/types';
import AppearanceTabs from '@/modules/admin/components/AppearanceTabs.vue';
import HeadingSmall from '@shared/components/HeadingSmall.vue';

import AdminLayout from '@modules/admin/layouts/AdminLayout.vue';
import SettingsLayout from '@modules/admin/layouts/SettingsLayout.vue';

const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Appearance settings',
        href: '/settings/appearance',
    },
];
</script>

<template>
    <AdminLayout :breadcrumbs="breadcrumbItems">
        <Head title="Appearance settings" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall title="Appearance settings" description="Update your account's appearance settings" />

                <AppearanceTabs />
            </div>
        </SettingsLayout>
    </AdminLayout>
</template>
