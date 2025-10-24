<script setup lang="ts">
import DashboardButton from '@/common/components/dashboards/form/DashboardButton.vue';
import type { BreadcrumbItem } from '@core/types';
import { Link } from '@inertiajs/vue3';
import Heading from '@shared/components/Heading.vue';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@ui/card';
import { Separator } from '@ui/separator';
import { ArrowLeft, ArrowRight, Loader2 } from 'lucide-vue-next';
import { computed } from 'vue';
import AdminLayout from './AdminLayout.vue';
import { __ } from '@/core/utils/translations';
import { usePage } from '@inertiajs/vue3';

export type ActionType = 'create' | 'edit' | 'show';

interface Props {
    /**
     * Action type: create, edit, or show
     */
    type: ActionType;

    /**
     * Page title (e.g., "Create User", "Edit User", "User Details")
     */
    title?: string;

    /**
     * Page description (optional)
     */
    description?: string;

    /**
     * Breadcrumbs for navigation
     */
    breadcrumbs?: BreadcrumbItem[];

    /**
     * Back link route/href
     */
    backHref?: string;

    /**
     * Back link label (defaults to "Back")
     */
    backLabel?: string;

    /**
     * Card title (defaults to title)
     */
    cardTitle?: string;

    /**
     * Card description (optional)
     */
    cardDescription?: string;

    /**
     * Show card wrapper (default: true)
     */
    showCard?: boolean;

    /**
     * Show footer separator (default: true for create/edit)
     */
    showFooterSeparator?: boolean;

    /**
     * Loading state
     */
    loading?: boolean;

    /**
     * Max width of content area
     * @default '2xl' for create/edit, '4xl' for show
     */
    maxWidth?: 'sm' | 'md' | 'lg' | 'xl' | '2xl' | '3xl' | '4xl' | '5xl' | 'full';
}

const props = withDefaults(defineProps<Props>(), {
    description: undefined,
    breadcrumbs: () => [],
    backHref: undefined,
    backLabel: 'Back',
    cardTitle: undefined,
    cardDescription: undefined,
    showCard: true,
    showFooterSeparator: undefined,
    loading: false,
    maxWidth: undefined,
});

const page = usePage();

// Computed properties
const computedMaxWidth = computed(() => {
    if (props.maxWidth) return props.maxWidth;
    return props.type === 'show' ? '4xl' : '2xl';
});

const computedShowFooterSeparator = computed(() => {
    if (props.showFooterSeparator !== undefined) return props.showFooterSeparator;
    return props.type === 'create' || props.type === 'edit';
});

const maxWidthClass = computed(() => {
    const widthMap = {
        sm: 'max-w-sm',
        md: 'max-w-md',
        lg: 'max-w-lg',
        xl: 'max-w-xl',
        '2xl': 'max-w-2xl',
        '3xl': 'max-w-3xl',
        '4xl': 'max-w-4xl',
        '5xl': 'max-w-5xl',
        full: 'max-w-full',
    };
    return widthMap[computedMaxWidth.value];
});
</script>

<template>
    <AdminLayout :breadcrumbs="breadcrumbs">
        <div class="p-4">
            <!-- Header -->
            <div :class="{ 'mb-6': !!title, 'mb-2': !title }">
                <!-- Back Button -->
                <DashboardButton v-if="backHref" variant="ghost" size="sm" as-child>
                    <Link :href="backHref">


                        <ArrowLeft class="h-4 w-4" v-if="$page.props.locale === 'en'" />
                        <ArrowRight class="h-4 w-4" v-if="$page.props.locale === 'ar'" />
                        {{ __('datatable.back') }}
                    </Link>
                </DashboardButton>

                <!-- Page Heading -->
                <Heading class="mt-4" :title="title ?? ''" :description="description" />
            </div>

            <!-- Loading State -->
            <div v-if="loading" class="flex items-center justify-center py-12">
                <Loader2 class="h-8 w-8 animate-spin text-muted-foreground" />
            </div>

            <!-- Content -->
            <div v-else :class="['mx-auto', maxWidthClass]">
                <!-- With Card -->
                <Card v-if="showCard">
                    <CardHeader v-if="cardTitle || cardDescription || $slots.header">
                        <slot name="header">
                            <CardTitle v-if="cardTitle">{{ cardTitle }}</CardTitle>
                            <CardDescription v-if="cardDescription">{{ cardDescription }}</CardDescription>
                        </slot>
                    </CardHeader>

                    <CardContent>
                        <slot />
                    </CardContent>

                    <CardFooter v-if="$slots.footer" :class="{ 'flex-col items-stretch gap-4': type !== 'show' }">
                        <Separator v-if="computedShowFooterSeparator" class="mb-4" />
                        <slot name="footer" />
                    </CardFooter>
                </Card>

                <!-- Without Card -->
                <div v-else class="space-y-6">
                    <!-- Header Slot -->
                    <div v-if="$slots.header">
                        <slot name="header" />
                    </div>

                    <!-- Main Content -->
                    <slot />

                    <!-- Footer Slot -->
                    <div v-if="$slots.footer">
                        <Separator v-if="computedShowFooterSeparator" class="mb-6" />
                        <slot name="footer" />
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
