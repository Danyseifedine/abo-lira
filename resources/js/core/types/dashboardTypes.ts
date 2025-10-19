import type { NavItem } from '@/core/types';

export interface LayoutConfig {
    containerVariant: 'sidebar' | 'header';
    sidebarDirection: 'left' | 'right';
    sidebarVariant: 'inset' | 'floating' | 'sidebar';
    sidebarCollapseButton: boolean;
    navbarAppearanceButton: boolean;
    navbarLogoutButton: boolean;
    navbarSettingsButton: boolean;
    navbarLanguageDropdown: boolean;
    sidebarTitleExist: boolean;
    sidebarTitle: string;
    sidebarPadding: string;
    sidebarNeonBorderColor: string;
    sidebarSubmenuStyle: 'tree' | 'bullet' | 'glass' | 'neon' | 'minimal';
    sidebarLogoExist: boolean;
    sidebarLogoSrc?: string;
    sidebarLogoPosition?: 'left' | 'center' | 'right';
    sidebarLogoSize?: string;
    sidebarLogoAlt?: string;
    sidebarLogoClassName?: string;
}

export interface NavigationConfig {
    mainItems: NavItem[];
    footerItems: NavItem[];
}

export interface RouteConfig {
    logoRedirect: string;
    settings: string;
}

export interface DashboardConfig {
    id: string;
    name: string;
    layout: LayoutConfig;
    navigation: NavigationConfig;
    routes: RouteConfig;
}

export type DashboardType = 'admin';
