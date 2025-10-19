<script setup lang="ts">
import { SidebarProvider } from '@ui/sidebar';
import { onMounted, ref } from 'vue';
import { Toaster } from 'vue-sonner';

interface Props {
    variant?: 'header' | 'sidebar';
}

defineProps<Props>();

const isOpen = ref(true);

onMounted(() => {
    isOpen.value = localStorage.getItem('sidebar') !== 'false';
});

const handleSidebarChange = (open: boolean) => {
    isOpen.value = open;
    localStorage.setItem('sidebar', String(open));
};
</script>

<template>
    <div v-if="variant === 'header'" class="flex min-h-screen w-full flex-col">
        <slot />
    </div>
    <SidebarProvider v-else :default-open="isOpen" :open="isOpen" @update:open="handleSidebarChange">
        <slot />
    </SidebarProvider>

    <!-- Toast notifications - positioned outside the sidebar context -->
    <Teleport to="body">
        <Toaster position="top-right" :duration="4000" theme="light" class="!fixed z-[9999]" />
    </Teleport>
</template>
