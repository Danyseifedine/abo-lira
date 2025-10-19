<script setup lang="ts">
import { __ } from '@/core/utils/translations';
import { filterNavigation, useGuard } from '@/guard';
import { useGlobalLayoutStore } from '@core/stores/layout';
import { type NavItem } from '@core/types';
import { Link, usePage } from '@inertiajs/vue3';
import {
    SidebarGroup,
    SidebarGroupLabel,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
    SidebarMenuSub,
    SidebarMenuSubButton,
    SidebarMenuSubItem,
    useSidebar,
} from '@ui/sidebar';
import { ChevronRight } from 'lucide-vue-next';
import { computed, onMounted, ref, watch } from 'vue';

const globalLayoutStore = useGlobalLayoutStore();
const { state: sidebarState } = useSidebar();

const props = defineProps<{
    items: NavItem[];
}>();

// Get current page from Inertia
const page = usePage();

// Get user permissions and roles
const { userPermissions, userRoles } = useGuard();

// Filter navigation items based on permissions
const filteredItems = computed(() => {
    return filterNavigation(props.items, userPermissions.value, userRoles.value);
});

// Track which dropdown menus are open
const openDropdowns = ref<Record<string, boolean>>({});

// Toggle dropdown state with accordion behavior
const toggleDropdown = (title: string) => {
    // If this dropdown is already open, just close it
    if (openDropdowns.value[title]) {
        openDropdowns.value[title] = false;
    } else {
        // Close all dropdowns first
        Object.keys(openDropdowns.value).forEach((key) => {
            openDropdowns.value[key] = false;
        });

        // Then open the clicked one
        openDropdowns.value[title] = true;
    }
};

// Check if an item is active based on current route
const isActive = (href: string) => {
    if (href === '#') return false;

    // Get the current URL path
    const currentPath = window.location.pathname;

    // For dashboard route - exact match only
    // if (href === route('dashboard')) {
    //     return currentPath === '/dashboard' || currentPath === '/dashboard/';
    // }

    // For other routes - check if current URL matches the route
    try {
        const routePath = new URL(href, window.location.origin).pathname;
        return currentPath === routePath;
    } catch (e) {
        // Fallback if URL parsing fails
        console.error(e);
        return route().current(href);
    }
};

// Check if any child of a dropdown is active
const hasActiveChild = (item: NavItem) => {
    if (!item.children) return false;
    return item.children.some((child) => isActive(child.href ?? ''));
};

// Update dropdown states based on current page
const updateDropdownStates = () => {
    // Close all dropdowns first
    Object.keys(openDropdowns.value).forEach((key) => {
        openDropdowns.value[key] = false;
    });

    for (const item of filteredItems.value) {
        if (item.children && hasActiveChild(item)) {
            openDropdowns.value[item.title] = true;
            break;
        }
    }

    saveOpenDropdowns();
};

// Store open dropdown state in localStorage to persist across page navigations
const saveOpenDropdowns = () => {
    localStorage.setItem('openDropdowns', JSON.stringify(openDropdowns.value));
};

// Load open dropdown state from localStorage
const loadOpenDropdowns = () => {
    const saved = localStorage.getItem('openDropdowns');
    if (saved) {
        openDropdowns.value = JSON.parse(saved);

        // Ensure only one dropdown is open (the first one found)
        let foundOpen = false;
        Object.keys(openDropdowns.value).forEach((key) => {
            if (openDropdowns.value[key] && !foundOpen) {
                foundOpen = true;
            } else if (openDropdowns.value[key] && foundOpen) {
                openDropdowns.value[key] = false;
            }
        });
    }
};

// Watch for page changes to update dropdown states
watch(
    () => page.url,
    () => {
        updateDropdownStates();
    },
);

// Save dropdown state whenever it changes
watch(
    openDropdowns,
    () => {
        saveOpenDropdowns();
    },
    { deep: true },
);

// Initialize dropdown state
onMounted(() => {
    // First load any saved state
    loadOpenDropdowns();

    // Then update based on current page
    updateDropdownStates();
});

// Improve height calculation to account for different styles
const getSubmenuHeight = (item: NavItem) => {
    if (!item.children) return '0px';

    // Use a more generous calculation to ensure enough space
    const baseHeight = 24; // Increased base padding
    const itemHeight = 52; // Height per item

    // Add extra padding for different styles
    let extraPadding = 0;
    if (globalLayoutStore.sidebarSubmenuStyle === 'glass') extraPadding = 32;
    if (globalLayoutStore.sidebarSubmenuStyle === 'neon') extraPadding = 32;

    return `${baseHeight + item.children.length * itemHeight + extraPadding}px`;
};

// Update computed classes to include new styles
const submenuContainerClass = computed(() => {
    switch (globalLayoutStore.sidebarSubmenuStyle) {
        case 'tree':
            return 'tree-menu-container';
        case 'bullet':
            return 'bullet-menu-container';
        case 'glass':
            return 'glass-menu-container';
        case 'neon':
            return 'neon-menu-container';
        case 'minimal':
        default:
            return 'minimal-menu-container';
    }
});

const submenuClass = computed(() => {
    switch (globalLayoutStore.sidebarSubmenuStyle) {
        case 'tree':
            return 'tree-menu';
        case 'bullet':
            return 'bullet-menu';
        case 'glass':
            return 'glass-menu';
        case 'neon':
            return 'neon-menu';
        case 'minimal':
        default:
            return 'minimal-menu';
    }
});

const submenuItemClass = computed(() => {
    switch (globalLayoutStore.sidebarSubmenuStyle) {
        case 'tree':
            return 'tree-menu-item';
        case 'bullet':
            return 'bullet-menu-item';
        case 'glass':
            return 'glass-menu-item';
        case 'neon':
            return 'neon-menu-item';
        case 'minimal':
        default:
            return 'minimal-menu-item';
    }
});

const isRTL = computed(() => {
    return document.documentElement.dir === 'rtl';
});

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
    <SidebarGroup class="px-2 py-0">
        <SidebarMenu>
            <template v-for="(item, index) in filteredItems" :key="index">
                <!-- Section header - only show when sidebar is expanded -->
                <template v-if="item.isSection && sidebarState === 'expanded'">
                    <SidebarGroupLabel class="mt-4">{{ translateTitle(item.title) }}</SidebarGroupLabel>
                </template>

                <!-- Regular menu item -->
                <SidebarMenuItem v-if="!item.isSection" class="mb-1">
                    <!-- Regular menu item without children -->
                    <template v-if="!item.children?.length">
                        <SidebarMenuButton
                            as-child
                            :is-active="isActive(item.href ?? '')"
                            :tooltip="translateTitle(item.title)"
                            class="transition-all duration-200 ease-in-out"
                            :class="globalLayoutStore.sidebarPadding"
                        >
                            <Link v-if="item.href !== '#'" :href="item.href ?? ''" class="flex items-center gap-2">
                                <component
                                    :is="item.icon"
                                    v-if="item.icon"
                                    class="font-bold transition-transform duration-200"
                                    :style="{
                                        color: item.iconColor || '',
                                        width: item.iconSize || '',
                                        height: item.iconSize || '',
                                        position: 'relative',
                                        [isRTL ? 'right' : 'left']: '-2px',
                                    }"
                                />
                                <span class="font-bold">{{ translateTitle(item.title) }}</span>
                            </Link>
                            <button v-else class="flex items-center gap-2">
                                <component
                                    :is="item.icon"
                                    v-if="item.icon"
                                    class="transition-transform duration-200"
                                    :style="{
                                        color: item.iconColor || '',
                                        width: item.iconSize || '',
                                        height: item.iconSize || '',
                                        [isRTL ? 'right' : 'left']: '-2px',
                                    }"
                                />
                                <span>{{ translateTitle(item.title) }}</span>
                            </button>
                        </SidebarMenuButton>
                    </template>

                    <!-- Dropdown menu item with children -->
                    <template v-else>
                        <SidebarMenuButton
                            @click="toggleDropdown(item.title)"
                            :is-active="openDropdowns[item.title] || hasActiveChild(item)"
                            :tooltip="translateTitle(item.title)"
                            class="transition-all duration-200 ease-in-out"
                            :class="globalLayoutStore.sidebarPadding"
                        >
                            <component :is="item.icon" v-if="item.icon" class="transition-transform duration-200" />
                            <span>{{ translateTitle(item.title) }}</span>
                            <ChevronRight
                                class="ml-auto h-4 w-4 transition-transform duration-300 rtl:rotate-180"
                                :class="{ 'rotate-90 rtl:-rotate-90': openDropdowns[item.title] }"
                            />
                        </SidebarMenuButton>

                        <div
                            class="overflow-hidden transition-all duration-300 ease-out"
                            style="width: 100%; max-width: 100%; box-sizing: border-box; overflow: hidden"
                            :style="{
                                maxHeight: openDropdowns[item.title] ? getSubmenuHeight(item) : '0px',
                                opacity: openDropdowns[item.title] ? '1' : '0',
                                marginTop: openDropdowns[item.title] ? '4px' : '0px',
                                paddingBottom: openDropdowns[item.title] ? '4px' : '0px',
                            }"
                        >
                            <div :class="submenuContainerClass" style="width: 100%; max-width: 100%; box-sizing: border-box; overflow: hidden">
                                <SidebarMenuSub
                                    :class="submenuClass"
                                    style="
                                        width: 100%;
                                        max-width: 100%;
                                        box-sizing: border-box;
                                        padding-left: 0;
                                        padding-right: 0;
                                        margin-left: 0;
                                        margin-right: 0;
                                    "
                                >
                                    <SidebarMenuSubItem v-for="(child, childIndex) in item.children" :key="childIndex" :class="submenuItemClass">
                                        <SidebarMenuSubButton as-child :is-active="isActive(child.href ?? '')" :tooltip="translateTitle(child.title)">
                                            <Link
                                                v-if="child.href !== '#'"
                                                :href="child.href ?? ''"
                                                class="flex items-center gap-2"
                                                :class="globalLayoutStore.sidebarPadding"
                                            >
                                                <component
                                                    :is="child.icon"
                                                    v-if="child.icon"
                                                    class="h-4 w-4"
                                                    :style="{
                                                        color: child.iconColor || '',
                                                        width: child.iconSize || '',
                                                        height: child.iconSize || '',
                                                    }"
                                                />
                                                <span class="text-sm">{{ translateTitle(child.title) }}</span>
                                            </Link>
                                            <button v-else class="flex items-center gap-2">
                                                <component
                                                    :is="child.icon"
                                                    v-if="child.icon"
                                                    class="h-4 w-4"
                                                    :style="{
                                                        color: child.iconColor || '',
                                                        width: child.iconSize || '',
                                                        height: child.iconSize || '',
                                                    }"
                                                />
                                                <span class="text-sm">{{ translateTitle(child.title) }}</span>
                                            </button>
                                        </SidebarMenuSubButton>
                                    </SidebarMenuSubItem>
                                </SidebarMenuSub>
                            </div>
                        </div>
                    </template>
                </SidebarMenuItem>
            </template>
        </SidebarMenu>
    </SidebarGroup>
</template>

<style scoped>
/* Tree menu styling - connecting lines between parent and children */
.tree-menu-container {
    margin-left: 12px;
    position: relative;
}

.tree-menu-container::before {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    width: 2px;
    background: rgba(100, 116, 139, 0.2);
    border-radius: 4px;
}

.tree-menu-item {
    position: relative;
    margin-left: 12px;
    width: calc(100% - 24px);
}

.tree-menu-item::before {
    content: '';
    position: absolute;
    top: 50%;
    left: -12px;
    width: 12px;
    height: 2px;
    background: rgba(100, 116, 139, 0.2);
    border-radius: 4px;
}

/* bullet menu styling - dots and subtle visual cues */
.bullet-menu-container {
    margin-left: 4px;
    position: relative;
}

.bullet-menu-item {
    position: relative;
    margin-left: 16px;
    width: calc(100% - 20px);
}

.bullet-menu-item::before {
    content: '';
    position: absolute;
    top: 50%;
    left: -16px;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: rgba(100, 116, 139, 0.4);
    transform: translateY(-50%);
    transition: all 0.2s ease;
}

.bullet-menu-item:has(.tree-menu-button:hover)::before {
    background: rgba(99, 102, 241, 0.6);
}

.bullet-menu-item:has(.tree-menu-button.is-active)::before {
    background: rgba(99, 102, 241, 0.8);
}

/* Minimal menu styling - simple indentation without visual elements */
.minimal-menu-container {
    margin-left: 4px;
}

.minimal-menu-item {
    margin-left: 12px;
    border-left: 2px solid transparent;
    transition: all 0.2s ease;
    width: calc(100% - 16px);
}

.minimal-menu-item:has(.tree-menu-button:hover) {
    border-left: 2px solid rgba(99, 102, 241, 0.4);
    width: 10px !important;
}

.minimal-menu-item:has(.tree-menu-button.is-active) {
    border-left: 2px solid rgba(99, 102, 241, 0.8);
}

/* Dark mode adjustments */
:root.dark .tree-menu-container::before,
:root.dark .tree-menu-item::before {
    background: rgba(148, 163, 184, 0.2);
}

:root.dark .bullet-menu-item::before {
    background: rgba(148, 163, 184, 0.4);
}

/* Light mode adjustments */
:root:not(.dark) .tree-menu-container::before,
:root:not(.dark) .tree-menu-item::before {
    background: rgba(100, 116, 139, 0.2);
}

:root:not(.dark) .bullet-menu-item::before {
    background: rgba(100, 116, 139, 0.4);
}

:root:not(.dark) .bullet-menu-item:has(.tree-menu-button:hover)::before {
    background: rgba(99, 102, 241, 0.6);
}

:root:not(.dark) .bullet-menu-item:has(.tree-menu-button.is-active)::before {
    background: rgba(99, 102, 241, 0.8);
}

:root:not(.dark) .minimal-menu-item:has(.tree-menu-button.is-active) {
    border-left: 2px solid rgba(99, 102, 241, 0.8);
}

/* Shared button styling for all menu types */
.tree-menu-button {
    position: relative;
    border-radius: 6px;
    transition: all 0.2s ease;
    z-index: 2;
}

/* Reset all container styles to ensure proper containment */
.sidebar-menu-sub {
    width: 100% !important;
    max-width: 100% !important;
    box-sizing: border-box !important;
    padding-left: 0 !important;
    padding-right: 0 !important;
    margin-left: 0 !important;
    margin-right: 0 !important;
    overflow: hidden !important;
}

/* Completely revised glass menu styling */
.glass-menu-container {
    position: relative;
    width: 100% !important;
    max-width: 100% !important;
    box-sizing: border-box !important;
    padding: 0 !important;
    margin: 0 !important;
    overflow: hidden !important;
}

.glass-menu {
    position: relative;
    width: 100% !important;
    max-width: 100% !important;
    box-sizing: border-box !important;
    padding: 8px 8px 12px 8px !important;
    margin: 4px -1px !important;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.03);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.05);
    /* box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); */
}

.glass-menu-item {
    width: 100% !important;
    max-width: 100% !important;
    box-sizing: border-box !important;
    margin: 4px 0 !important;
    padding: 0 !important;
    border-radius: 6px;
}

.glass-menu-item .sidebar-menu-sub-button {
    width: 100% !important;
    max-width: 100% !important;
    box-sizing: border-box !important;
    border-radius: 6px;
    background: rgba(255, 255, 255, 0.03);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    border: 1px solid rgba(255, 255, 255, 0);
}

/* Completely revised neon menu styling */
.neon-menu-container {
    position: relative;
    width: 100% !important;
    max-width: 100% !important;
    box-sizing: border-box !important;
    padding: 0 !important;
    margin: 0 !important;
    overflow: hidden !important;
}

.neon-menu {
    position: relative;
    width: 100% !important;
    max-width: 100% !important;
    box-sizing: border-box !important;
    padding: 8px 8px 12px 8px !important;
    margin: 4px 0 !important;
    border-radius: 6px;
    background: rgba(35, 35, 35, 0.6);
    border-left: 2px solid v-bind('globalLayoutStore.sidebarNeonBorderColor');
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.neon-menu-item {
    width: 100% !important;
    max-width: 100% !important;
    box-sizing: border-box !important;
    margin: 2px 0 !important;
    padding: 0 !important;
    border-radius: 4px;
}

.neon-menu-item .sidebar-menu-sub-button {
    width: 100% !important;
    max-width: 100% !important;
    box-sizing: border-box !important;
    border-radius: 4px;
    background: rgba(30, 41, 59, 0.4);
    transition: all 0.3s ease;
    border-left: 3px solid transparent;
    position: relative;
}

/* Enhanced hover effect */
.neon-menu-item .sidebar-menu-sub-button:hover {
    background: rgba(30, 41, 59, 0.6);
    border-left: 3px solid rgba(217, 255, 0, 0.5);
    transform: translateX(3px);
}

/* Fixed active state styling */
.neon-menu-item .sidebar-menu-sub-button.is-active {
    background: rgba(30, 41, 59, 0.8);
    border-left: 3px solid #d9ff00;
    transform: translateX(5px);
}

/* Light mode adjustments */
:root:not(.dark) .neon-menu {
    background: rgba(249, 250, 251, 0.8) !important;
    border-left: 2px solid v-bind('globalLayoutStore.sidebarNeonBorderColor') !important;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.1) !important;
}

/* Fix animation container */
.overflow-hidden.transition-all {
    max-width: 100%;
    box-sizing: border-box;
}

/* Improved light mode styling for glass and neon styles */

/* Glass style light mode improvements */
:root:not(.dark) .glass-menu {
    background: rgba(255, 255, 255, 0.7) !important;
    backdrop-filter: blur(12px) !important;
    -webkit-backdrop-filter: blur(12px) !important;
    border: 1px solid rgba(226, 232, 240, 0.7) !important;
    /* box-shadow: 0 8px 16px rgba(148, 163, 184, 0.1) !important; */
}

:root:not(.dark) .glass-menu-item .sidebar-menu-sub-button {
    background: rgba(255, 255, 255, 0.5) !important;
    border: 1px solid rgba(226, 232, 240, 0.3) !important;
    color: #1e293b !important;
}

:root:not(.dark) .glass-menu-item .sidebar-menu-sub-button:hover {
    background: rgba(255, 255, 255, 0.8) !important;
    border: 1px solid rgba(99, 102, 241, 0.3) !important;
    transform: translateY(-2px) !important;
    /* box-shadow: 0 4px 8px rgba(99, 102, 241, 0.1) !important; */
}

:root:not(.dark) .glass-menu-item .sidebar-menu-sub-button.is-active {
    background: rgba(224, 231, 255, 0.8) !important;
    border: 1px solid rgba(99, 102, 241, 0.5) !important;
    /* box-shadow: 0 4px 12px rgba(99, 102, 241, 0.2) !important; */
}

:root:not(.dark) .glass-menu-item .sidebar-menu-sub-button:hover .h-4,
:root:not(.dark) .glass-menu-item .sidebar-menu-sub-button:hover svg,
:root:not(.dark) .glass-menu-item .sidebar-menu-sub-button:hover .text-sm {
    color: #4f46e5 !important;
}

:root:not(.dark) .glass-menu-item .sidebar-menu-sub-button.is-active .h-4,
:root:not(.dark) .glass-menu-item .sidebar-menu-sub-button.is-active svg,
:root:not(.dark) .glass-menu-item .sidebar-menu-sub-button.is-active .text-sm {
    color: #4338ca !important;
}

/* Neon style light mode improvements */
:root:not(.dark) .neon-menu {
    background: rgba(249, 250, 251, 0.8) !important;
    box-shadow: 1px 1px 2px rgba(99, 102, 241, 0.1) !important;
}

:root:not(.dark) .neon-menu-item .sidebar-menu-sub-button {
    background: rgba(249, 250, 251, 0.6) !important;
    color: #1e293b !important;
    border-left: 3px solid transparent !important;
}

:root:not(.dark) .neon-menu-item .sidebar-menu-sub-button:hover {
    background: rgba(249, 250, 251, 0.9) !important;
    border-left: 3px solid rgba(99, 102, 241, 0.5) !important;
    transform: translateX(3px) !important;
}

:root:not(.dark) .neon-menu-item .sidebar-menu-sub-button.is-active {
    background: rgba(224, 231, 255, 0.8) !important;
    border-left: 3px solid #6366f1 !important;
    transform: translateX(5px) !important;
}

:root:not(.dark) .neon-menu-item .sidebar-menu-sub-button:hover .h-4,
:root:not(.dark) .neon-menu-item .sidebar-menu-sub-button:hover svg,
:root:not(.dark) .neon-menu-item .sidebar-menu-sub-button:hover .text-sm {
    color: #4f46e5 !important;
}

:root:not(.dark) .neon-menu-item .sidebar-menu-sub-button.is-active .h-4,
:root:not(.dark) .neon-menu-item .sidebar-menu-sub-button.is-active svg,
:root:not(.dark) .neon-menu-item .sidebar-menu-sub-button.is-active .text-sm {
    color: #4338ca !important;
}

.glass-menu-item .h-4,
.glass-menu-item svg,
.neon-menu-item .h-4,
.neon-menu-item svg {
    transition: all 0.3s ease !important;
}

.glass-menu-item .text-sm,
.neon-menu-item .text-sm {
    transition: all 0.3s ease !important;
}

/* RTL specific adjustments */
[dir='rtl'] .tree-menu-container {
    margin-left: 0;
    margin-right: 12px;
}

[dir='rtl'] .tree-menu-container::before {
    left: auto;
    right: 0;
}

[dir='rtl'] .tree-menu-item {
    margin-left: 0;
    margin-top: 3px;
    margin-right: 12px;
    width: calc(100% - 24px);
}

[dir='rtl'] .tree-menu-item::before {
    left: auto;
    right: -12px;
}

[dir='rtl'] .bullet-menu-container {
    margin-left: 0;
    margin-right: 10px;
    width: calc(100% - 6px) !important;
}

[dir='rtl'] .bullet-menu-item {
    margin-left: 0;
    margin-right: 16px;
}

[dir='rtl'] .bullet-menu-item::before {
    left: auto;
    right: -14px;
}

[dir='rtl'] .minimal-menu-item {
    margin-left: 0;
    margin-right: 12px;
    border-left: none;
    border-right: 2px solid transparent;
}

[dir='rtl'] .minimal-menu-item:has(.tree-menu-button:hover) {
    border-left: none;
    border-right: 2px solid rgba(99, 102, 241, 0.4);
}

[dir='rtl'] .minimal-menu-item:has(.tree-menu-button.is-active) {
    border-left: none;
    border-right: 2px solid rgba(99, 102, 241, 0.8);
}

[dir='rtl'] .neon-menu {
    border-left: none;
    border-right: 2px solid v-bind('globalLayoutStore.sidebarNeonBorderColor');
}

[dir='rtl'] .neon-menu-item .sidebar-menu-sub-button {
    border-left: none;
    border-right: 3px solid transparent;
}

[dir='rtl'] .neon-menu-item .sidebar-menu-sub-button:hover {
    border-left: none;
    border-right: 3px solid rgba(217, 255, 0, 0.5);
    transform: translateX(-3px);
}

[dir='rtl'] .neon-menu-item .sidebar-menu-sub-button.is-active {
    border-left: none;
    border-right: 3px solid #d9ff00;
    transform: translateX(-5px);
}

/* Light mode RTL adjustments */
:root:not(.dark) [dir='rtl'] .neon-menu-item .sidebar-menu-sub-button:hover {
    border-left: none !important;
    border-right: 3px solid rgba(99, 102, 241, 0.5) !important;
    transform: translateX(-3px) !important;
}

:root:not(.dark) [dir='rtl'] .neon-menu-item .sidebar-menu-sub-button.is-active {
    border-left: none !important;
    border-right: 3px solid #6366f1 !important;
    transform: translateX(-5px) !important;
}

/* RTL specific adjustments for all menu types */
[dir='rtl'] .sidebar-menu-button {
    text-align: right;
}

[dir='rtl'] .ml-auto {
    margin-left: 0;
    margin-right: auto;
}

/* Glass menu RTL adjustments */

[dir='rtl'] .glass-menu {
    margin: 4px 1px !important;
}
[dir='rtl'] .glass-menu-container {
    width: 100% !important;
}

[dir='rtl'] .glass-menu-item .sidebar-menu-sub-button {
    text-align: right;
}

[dir='rtl'] .glass-menu-item .sidebar-menu-sub-button:hover {
    transform: translateY(-2px) !important;
}

/* Fix icon alignment in RTL for all menu types */
[dir='rtl'] .flex.items-center.gap-2 {
    /* flex-direction: row-reverse; */
    justify-content: flex-start;
}

/* Fix chevron alignment in RTL */
[dir='rtl'] .sidebar-menu-button .ml-auto {
    transform: rotate(180deg);
}
</style>
