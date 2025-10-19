import type { PageProps } from '@inertiajs/core';
import type { Config } from 'ziggy-js';
import type { Component } from 'vue';

// Extend ColumnMeta from @tanstack/vue-table
declare module '@tanstack/vue-table' {
    interface ColumnMeta {
        label?: string;
        width?: number | string;
        className?: string;
        headerClassName?: string;
    }
}

export interface Auth {
    user: User;
    is_authenticated: boolean;
    permissions: string[];
    roles: string[];
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href?: string;
    icon?: Component;
    iconColor?: string; // Custom color for the icon (CSS color value)
    iconSize?: string; // Custom size for the icon (CSS size value like '1.5rem', '24px', etc.)
    permission?: string;
    role?: string;
    permissions?: string[];
    roles?: string[];
    requireAll?: boolean; // If true, user must have ALL permissions/roles. If false (default), user needs ANY
    children?: NavItem[];
    isSection?: boolean;
}

export interface SharedData extends PageProps {
    name: string;
    auth: Auth;
    ziggy: Config & { location: string };
    flash?: {
        toast?: {
            type: 'success' | 'error' | 'info' | 'warning';
            title: string;
            message: string;
        };
    };
}

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    avatar_url?: string | null;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export type BreadcrumbItemType = BreadcrumbItem;
