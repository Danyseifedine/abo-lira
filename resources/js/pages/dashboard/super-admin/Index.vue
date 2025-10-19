<script setup lang="ts">
import { type BreadcrumbItem } from '@core/types';
import { Head } from '@inertiajs/vue3';
import AdminLayout from '@modules/admin/layouts/AdminLayout.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: route('super-admin.dashboard'),
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">hello world</div>
    </AdminLayout>
</template>
