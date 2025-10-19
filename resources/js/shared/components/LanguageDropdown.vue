<script setup lang="ts">
import { usePage } from '@inertiajs/vue3';
import { Button } from '@ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuTrigger } from '@ui/dropdown-menu';
import { Check, Languages } from 'lucide-vue-next';

const page = usePage();
const currentLocale = page.props.locale as string;

const languages = [
    { code: 'en', name: 'English', flag: '🇺🇸' },
    { code: 'ar', name: 'العربية', flag: '🇸🇦' },
];

const switchLanguage = (locale: string) => {
    if (locale === currentLocale) return;

    // Get current path without locale prefix
    const currentPath = window.location.pathname;
    const pathSegments = currentPath.split('/').filter((segment) => segment);

    // Remove current locale from path if it exists
    if (pathSegments.length > 0 && ['en', 'ar'].includes(pathSegments[0])) {
        pathSegments.shift();
    }

    // Build new URL with new locale
    const newPath = `/${locale}/${pathSegments.join('/')}`;
    const newUrl = `${window.location.origin}${newPath}${window.location.search}`;

    window.location.href = newUrl;
};
</script>

<template>
    <DropdownMenu :modal="false">
        <DropdownMenuTrigger as-child>
            <Button variant="secondary" size="icon" class="h-8 w-8">
                <Languages class="h-4 w-4" />
                <span class="sr-only">Change language</span>
            </Button>
        </DropdownMenuTrigger>
        <DropdownMenuContent align="end" class="w-48" :avoid-collisions="false">
            <DropdownMenuItem
                v-for="language in languages"
                :key="language.code"
                @click="switchLanguage(language.code)"
                class="flex cursor-pointer items-center justify-between"
                :class="{ 'bg-accent': language.code === currentLocale }"
            >
                <div class="flex items-center gap-2">
                    <span class="text-base">{{ language.flag }}</span>
                    <span>{{ language.name }}</span>
                </div>
                <Check v-if="language.code === currentLocale" class="h-4 w-4 text-primary" />
            </DropdownMenuItem>
        </DropdownMenuContent>
    </DropdownMenu>
</template>
