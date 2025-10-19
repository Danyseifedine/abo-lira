<script setup lang="ts">
import AppContent from '@shared/components/AppContent.vue';
import AppShell from '@shared/components/AppShell.vue';
import AppSidebar from '@shared/components/AppSidebar.vue';
import AppSidebarHeader from '@shared/components/AppSidebarHeader.vue';
import { useGlobalLayoutStore } from '@/core/stores/layout';
import type { BreadcrumbItemType } from '@/core/types';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

const globalLayoutStore = useGlobalLayoutStore();

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});
</script>

<template>
    <AppShell>
        <AppSidebar />
        <AppContent :variant="globalLayoutStore.containerVariant">
            <AppSidebarHeader :breadcrumbs="breadcrumbs" />
            <slot />
        </AppContent>
    </AppShell>
</template>
