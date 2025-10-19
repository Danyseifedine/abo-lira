<script setup lang="ts">
import { __ } from '@/core/utils/translations';
import { useGlobalLayoutStore } from '@core/stores/layout';
import { type NavItem } from '@core/types';
import { SidebarGroup, SidebarGroupContent, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@ui/sidebar';

const globalLayoutStore = useGlobalLayoutStore();

interface Props {
    items: NavItem[];
    class?: string;
}

defineProps<Props>();

// Helper function to translate titles - checks if title is a translation key
const translateTitle = (title: string): string => {
    // If title contains a dot, it's likely a translation key
    if (title.includes('.')) {
        return __(title);
    }
    return title;
};
</script>

<template>
    <SidebarGroup :class="`group-data-[collapsible=icon]:p-0 ${$props.class || ''}`">
        <SidebarGroupContent>
            <SidebarMenu>
                <SidebarMenuItem v-for="item in items" :key="item.title">
                    <SidebarMenuButton
                        class="text-neutral-600 hover:text-neutral-800 dark:text-neutral-300 dark:hover:text-neutral-100"
                        :class="globalLayoutStore.sidebarPadding"
                        as-child
                    >
                        <a :href="item.href" target="_blank" rel="noopener noreferrer">
                            <component :is="item.icon" />
                            <span>{{ translateTitle(item.title) }}</span>
                        </a>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarGroupContent>
    </SidebarGroup>
</template>
