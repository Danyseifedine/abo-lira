<script setup lang="ts">
import NavFooter from '@shared/components/NavFooter.vue';
import NavMain from '@shared/components/NavMain.vue';
import NavUser from '@shared/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@ui/sidebar';
import { useGlobalLayoutRouteStore, useGlobalLayoutStore } from '@core/stores/layout';
import { Link } from '@inertiajs/vue3';
import AppLogo from './AppLogo.vue';

const globalLayoutStore = useGlobalLayoutStore();
const globalLayoutRouteStore = useGlobalLayoutRouteStore();
</script>

<template>
    <Sidebar :side="globalLayoutStore.sidebarDirection" collapsible="icon" :variant="globalLayoutStore.sidebarVariant">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="globalLayoutRouteStore.logoRedirectPath" class="flex items-center">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="globalLayoutStore.sidebarMainItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="globalLayoutStore.sidebarFooterItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>

<style scoped>
/* RTL specific adjustments */
:root[dir='rtl'] .sidebar-menu-button {
    text-align: right;
}

:root[dir='rtl'] .flex.items-center.gap-2 {
    flex-direction: row-reverse;
    justify-content: flex-start;
}

:root[dir='rtl'] .ml-auto {
    margin-left: 0;
    margin-right: auto;
}
</style>
