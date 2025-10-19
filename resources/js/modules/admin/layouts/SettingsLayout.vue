<script setup lang="ts">
import Heading from '@shared/components/Heading.vue';
import { Button } from '@ui/button';
import { Separator } from '@ui/separator';
import { type NavItem } from '@/core/types';
import { Link, usePage } from '@inertiajs/vue3';

const sidebarNavItems: NavItem[] = [
    {
        title: 'Profile',
        href: route('super-admin.profile.edit'),
    },
    {
        title: 'Password',
        href: route('super-admin.profile.password.edit'),
    },
];

const page = usePage();

// Fix type error by safely accessing ziggy.location and ensuring it's a string
const ziggy = page.props.ziggy as { location?: string } | undefined;
const currentPath = typeof ziggy?.location === 'string' ? new URL(ziggy.location).pathname : '';
</script>

<template>
    <div class="px-4 py-6">
        <Heading
            title="Profile & Security"
            description="Update your personal information, change your password, and manage important aspects of your account to keep it secure and tailored to your needs."
        />

        <div class="flex flex-col space-y-8 md:space-y-0 lg:flex-row lg:space-x-12 lg:space-y-0">
            <aside class="w-full max-w-xl lg:w-48">
                <nav class="flex flex-col space-x-0 space-y-1">
                    <Button
                        v-for="item in sidebarNavItems"
                        :key="item.href"
                        variant="ghost"
                        :class="['w-full justify-start', { 'bg-muted': currentPath === item.href }]"
                        as-child
                    >
                        <Link :href="item.href ?? ''">
                            {{ item.title }}
                        </Link>
                    </Button>
                </nav>
            </aside>

            <Separator class="my-6 md:hidden" />

            <div class="flex-1 md:max-w-2xl">
                <section class="max-w-xl space-y-12">
                    <slot />
                </section>
            </div>
        </div>
    </div>
</template>
