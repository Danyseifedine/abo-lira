import { useGlobalLayoutStore, useGlobalLayoutRouteStore } from '@/core/stores/layout';
import type { DashboardConfig } from '@/core/types/dashboardTypes';

export function useDashboardConfig(config: DashboardConfig) {
    const globalLayoutStore = useGlobalLayoutStore();
    const globalLayoutRouteStore = useGlobalLayoutRouteStore();

    // Apply layout configuration
    globalLayoutStore.applyLayoutConfig(config.layout);

    // Apply navigation configuration
    globalLayoutStore.setSidebarMainItems(config.navigation.mainItems);
    globalLayoutStore.setSidebarFooterItems(config.navigation.footerItems);

    // Apply route configuration
    globalLayoutRouteStore.setLogoRedirectPath(config.routes.logoRedirect);
    globalLayoutRouteStore.setSettingsPath(config.routes.settings);

    return {
        config,
        layoutStore: globalLayoutStore,
        routeStore: globalLayoutRouteStore,
    };
}
