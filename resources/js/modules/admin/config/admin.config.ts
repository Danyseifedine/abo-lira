import type { DashboardConfig } from '../../../core/types/dashboardTypes';
import type { NavItem } from "@/core/types";
import {
    BookOpen,
    Key,
    User,
    LayoutGrid,
    Shield,
    Settings,
} from "lucide-vue-next";

const getAdminSidebarMainItems = (): NavItem[] => [
    {
        title: 'Dashboard',
        href: route('super-admin.dashboard'),
        icon: LayoutGrid,
        iconColor: '#3b82f6', // blue-500 (informative/overview)
        iconSize: '1.25rem',
        permissions: ['access-super-admin-dashboard'],
    },
    {
        title: 'Pages',
        isSection: true,
    },
    {
        title: 'Users',
        href: route('super-admin.users.index'),
        icon: User,
        iconColor: '#16a34a', // green-600 (people/growth)
        iconSize: '1.25rem',
        permissions: ['access-super-admin-dashboard'],
    },
    {
        title: 'Settings & Security',
        isSection: true,
    },
    {
        title: 'Roles',
        href: route('super-admin.roles.index'),
        icon: Shield,
        iconColor: '#f59e42',
        iconSize: '1.25rem',
        permissions: ['access-super-admin-role'],
    },
    {
        title: 'Permissions',
        href: route('super-admin.permissions.index'),
        icon: Key,
        iconColor: '#8b5cf6', // purple-500 (key/access/security)
        iconSize: '1.25rem',
        permissions: ['access-super-admin-permission'],
    },
];

const getAdminSidebarFooterItems = (): NavItem[] => [
    {
        title: 'Documentation',
        href: route('super-admin.documentation'),
        icon: BookOpen,
        iconColor: '#8b5cf6',
        iconSize: '1.25rem',
    },
];

export const adminDashboardConfig: DashboardConfig = {
    id: 'admin',
    name: 'Admin Dashboard',
    layout: {
        containerVariant: 'sidebar',
        sidebarDirection: document.documentElement.dir === 'rtl' ? "right" : "left",
        sidebarVariant: 'inset',
        sidebarCollapseButton: true,
        navbarAppearanceButton: true,
        navbarLogoutButton: true,
        navbarSettingsButton: true,
        navbarLanguageDropdown: false,
        sidebarTitleExist: true,
        sidebarTitle: 'Dashboard',
        sidebarPadding: 'py-5',
        sidebarNeonBorderColor: '#fff',
        sidebarSubmenuStyle: 'tree',
        sidebarLogoExist: true,
        // sidebarLogoSrc: '/assets/images/logo.png',
        // sidebarLogoPosition: 'left',
        // sidebarLogoSize: '2.5rem',
        // sidebarLogoAlt: 'Admin Dashboard Logo',
        // sidebarLogoClassName: 'object-contain rounded-md',
    },
    navigation: {
        mainItems: getAdminSidebarMainItems(),
        footerItems: getAdminSidebarFooterItems(),
    },
    routes: {
        logoRedirect: route('super-admin.dashboard'),
        settings: route('super-admin.profile.edit'),
    },
};
