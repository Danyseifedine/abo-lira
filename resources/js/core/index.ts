// Core Framework Exports - Everything needed across the application

// Layout System
export { useGlobalLayoutStore, useGlobalLayoutRouteStore } from './stores/layout';
export type { LayoutInterface, LayoutRouteInterface } from './stores/layout.types';

// Dashboard Configuration System
export { useDashboardConfig } from './composables/useDashboardConfig';
export type { DashboardConfig, LayoutConfig, NavigationConfig, RouteConfig } from './types/dashboardTypes';

// Core Composables
export { useAppearance } from './composables/useAppearance';
export { useInitials } from './composables/useInitials';

// Core Layouts
// Utilities
export * from './utils/utils';
export * from './utils/converters';
export * from './utils/formatters';

// Types
export * from './types';
