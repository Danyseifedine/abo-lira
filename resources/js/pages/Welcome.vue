<script setup lang="ts">
import { useGuard } from '@/guard';
import type { SharedData } from '@core/types';
import { Head, Link, usePage } from '@inertiajs/vue3';
import GuestLayout from '@shared/layouts/GuestLayout.vue';

defineOptions({
    layout: GuestLayout,
});

const page = usePage<SharedData>();
const isAuthenticated = page.props.auth.is_authenticated;
const { is } = useGuard();
</script>

<template>
    <Head title="Welcome" />
    <div class="flex min-h-[60vh] flex-col items-center justify-center gap-6">
        <h1 class="mb-2 text-3xl font-bold">Welcome to the Starter Kit</h1>
        <p class="mb-6 text-gray-500">Please log in or register to continue.</p>
        <div class="flex gap-4">
            <template v-if="!isAuthenticated">
                <Link href="/login" class="rounded bg-blue-600 px-6 py-2 font-semibold text-white transition hover:bg-blue-700"> Login </Link>
                <Link href="/register" class="rounded bg-gray-200 px-6 py-2 font-semibold text-gray-800 transition hover:bg-gray-300">
                    Register
                </Link>
            </template>
            <template v-if="is('super-admin')">
                <Link
                    :href="route('super-admin.dashboard')"
                    class="rounded bg-blue-600 px-6 py-2 font-semibold text-white transition hover:bg-blue-700"
                >
                    Dashboard
                </Link>
            </template>
            <Link
                v-if="isAuthenticated"
                :href="route('logout')"
                method="post"
                as="button"
                class="rounded bg-blue-600 px-6 py-2 font-semibold text-white transition hover:bg-blue-700"
            >
                Logout
            </Link>
        </div>
    </div>
</template>
