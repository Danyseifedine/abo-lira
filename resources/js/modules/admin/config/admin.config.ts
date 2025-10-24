import type { DashboardConfig } from '../../../core/types/dashboardTypes';
import type { NavItem } from "@/core/types";
import {
    BookOpen,
    Users,
    LayoutDashboard,
    Shield,
    Package2,
    FolderTree,
    BadgeCheck,
    Gift,
    Palette,
    Maximize2,
    ShieldAlert,
} from "lucide-vue-next";

const getAdminSidebarMainItems = (): NavItem[] => [
    {
        title: 'sidebar.dashboard',
        href: route('super-admin.dashboard'),
        icon: LayoutDashboard,
        iconColor: '#3b82f6', // blue-500 (informative/overview)
        iconSize: '1.25rem',
        permissions: ['access-super-admin-dashboard'],
    },


    {
        title: 'sidebar.pages',
        isSection: true,
        permissions: ['access-super-admin-users'],
    },
    {
        title: 'sidebar.users',
        href: route('super-admin.users.index'),
        icon: Users,
        iconColor: '#10b981', // emerald-500 (people/community)
        iconSize: '1.25rem',
        permissions: ['access-super-admin-users'],
    },

    {
        title: 'sidebar.catalog_inventory',
        isSection: true,
        permissions: ['access-super-admin-products'],
    },

    {
        title: 'sidebar.products',
        href: route('super-admin.products.index'),
        icon: Package2,
        iconColor: '#f97316', // orange-500 (products/inventory)
        iconSize: '1.25rem',
        permissions: ['access-super-admin-products'],
    },
    {
        title: 'sidebar.product_categories',
        href: route('super-admin.product-categories.index'),
        icon: FolderTree,
        iconColor: '#8b5cf6', // violet-500 (organization/hierarchy)
        iconSize: '1.25rem',
        permissions: ['access-super-admin-product-categories'],
    },
    {
        title: 'sidebar.product_qualities',
        href: route('super-admin.product-qualities.index'),
        icon: BadgeCheck,
        iconColor: '#059669', // emerald-600 (quality/premium)
        iconSize: '1.25rem',
        permissions: ['access-super-admin-product-qualities'],
    },
    {
        title: 'sidebar.product_colors',
        href: route('super-admin.product-colors.index'),
        icon: Palette,
        iconColor: '#ec4899', // pink-500 (colors/design)
        iconSize: '1.25rem',
        permissions: ['access-super-admin-product-colors'],
    },

    {
        title: 'sidebar.product_sizes',
        href: route('super-admin.product-sizes.index'),
        icon: Maximize2,
        iconColor: '#06b6d4', // cyan-500 (measurements/dimensions)
        iconSize: '1.25rem',
        permissions: ['access-super-admin-product-sizes'],
    },

    {
        title: 'sidebar.product_bundles',
        // href: route('super-admin.product-bundles.index'),
        icon: Gift,
        iconColor: '#6366f1', // indigo-500 (deals/special offers)
        iconSize: '1.25rem',
        permissions: ['access-super-admin-product-bundles'],
    },

    {
        title: 'sidebar.settings_security',
        isSection: true,
        permissions: ['access-super-admin-role'],
    },
    {
        title: 'sidebar.roles',
        href: route('super-admin.roles.index'),
        icon: Shield,
        iconColor: '#f59e0b', // amber-500 (authority/protection)
        iconSize: '1.25rem',
        permissions: ['access-super-admin-role'],
    },
    {
        title: 'sidebar.permissions',
        href: route('super-admin.permissions.index'),
        icon: ShieldAlert,
        iconColor: '#dc2626', // red-600 (security/access control)
        iconSize: '1.25rem',
        permissions: ['access-super-admin-permission'],
    },
];

const getAdminSidebarFooterItems = (): NavItem[] => [
    {
        title: 'sidebar.documentation',
        href: route('super-admin.documentation'),
        icon: BookOpen,
        iconColor: '#2563eb', // blue-600 (knowledge/learning)
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
        navbarAppearanceButton: false,
        navbarLogoutButton: true,
        navbarSettingsButton: false,
        navbarLanguageDropdown: true,
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
