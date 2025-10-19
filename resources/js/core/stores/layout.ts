import { defineStore } from 'pinia';
import type { LayoutInterface, LayoutRouteInterface } from './layout.types';
import type { NavItem } from '@/core/types';
import type { LayoutConfig } from '@/core/types/dashboardTypes';

export const useGlobalLayoutStore = defineStore('globalLayout', {
    state: (): LayoutInterface => ({
        containerVariant: 'sidebar',
        sidebarDirection: 'left',
        sidebarVariant: 'inset',
        sidebarMainItems: [],
        sidebarFooterItems: [],
        sidebarCollapseButton: true,
        navbarAppearanceButton: true,
        navbarLanguageDropdown: true,
        navbarLogoutButton: true,
        navbarSettingsButton: true,
        sidebarTitleExist: true,
        sidebarTitle: '',
        sidebarPadding: '',
        sidebarNeonBorderColor: '',
        sidebarSubmenuStyle: 'tree',
        sidebarLogoExist: false,
        sidebarLogoSrc: '',
        sidebarLogoPosition: 'left',
        sidebarLogoSize: '2rem',
        sidebarLogoAlt: 'Logo',
        sidebarLogoClassName: '',
    }),

    actions: {
        setContainerVariant(variant: 'sidebar' | 'header') {
            this.containerVariant = variant;
        },
        setSidebarDirection(direction: 'left' | 'right') {
            this.sidebarDirection = direction;
        },
        setSidebarVariant(variant: 'inset' | 'floating' | 'sidebar') {
            this.sidebarVariant = variant;
        },
        setSidebarMainItems(items: NavItem[]) {
            this.sidebarMainItems = items;
        },
        setSidebarFooterItems(items: NavItem[]) {
            this.sidebarFooterItems = items;
        },
        setSidebarCollapseButton(collapseButton: boolean) {
            this.sidebarCollapseButton = collapseButton;
        },
        setNavbarAppearanceButton(appearanceButton: boolean) {
            this.navbarAppearanceButton = appearanceButton;
        },
        setNavbarLogoutButton(logoutButton: boolean) {
            this.navbarLogoutButton = logoutButton;
        },
        setNavbarLanguageDropdown(languageDropdown: boolean) {
            this.navbarLanguageDropdown = languageDropdown;
        },
        setNavbarSettingsButton(settingsButton: boolean) {
            this.navbarSettingsButton = settingsButton;
        },
        setSidebarTitleExist(titleExist: boolean) {
            this.sidebarTitleExist = titleExist;
        },
        setSidebarTitle(title: string) {
            this.sidebarTitle = title;
        },
        setSidebarPadding(padding: string) {
            this.sidebarPadding = padding;
        },
        setSidebarNeonBorderColor(borderColor: string) {
            this.sidebarNeonBorderColor = borderColor;
        },
        setSidebarSubmenuStyle(style: 'tree' | 'bullet' | 'glass' | 'neon' | 'minimal') {
            this.sidebarSubmenuStyle = style;
        },
        setSidebarLogoExist(logoExist: boolean) {
            this.sidebarLogoExist = logoExist;
        },
        setSidebarLogoSrc(logoSrc: string) {
            this.sidebarLogoSrc = logoSrc;
        },
        setSidebarLogoPosition(logoPosition: 'left' | 'center' | 'right') {
            this.sidebarLogoPosition = logoPosition;
        },
        setSidebarLogoSize(logoSize: string) {
            this.sidebarLogoSize = logoSize;
        },
        setSidebarLogoAlt(logoAlt: string) {
            this.sidebarLogoAlt = logoAlt;
        },
        setSidebarLogoClassName(logoClassName: string) {
            this.sidebarLogoClassName = logoClassName;
        },
        applyLayoutConfig(config: LayoutConfig) {
            this.setContainerVariant(config.containerVariant);
            this.setSidebarDirection(config.sidebarDirection);
            this.setSidebarVariant(config.sidebarVariant);
            this.setSidebarCollapseButton(config.sidebarCollapseButton);
            this.setNavbarAppearanceButton(config.navbarAppearanceButton);
            this.setNavbarLogoutButton(config.navbarLogoutButton);
            this.setNavbarSettingsButton(config.navbarSettingsButton);
            this.setNavbarLanguageDropdown(config.navbarLanguageDropdown);
            this.setSidebarTitleExist(config.sidebarTitleExist);
            this.setSidebarTitle(config.sidebarTitle);
            this.setSidebarPadding(config.sidebarPadding);
            this.setSidebarNeonBorderColor(config.sidebarNeonBorderColor);
            this.setSidebarSubmenuStyle(config.sidebarSubmenuStyle);
            this.setSidebarLogoExist(config.sidebarLogoExist);
            if (config.sidebarLogoSrc) this.setSidebarLogoSrc(config.sidebarLogoSrc);
            this.setSidebarLogoPosition(config.sidebarLogoPosition);
            if (config.sidebarLogoSize) this.setSidebarLogoSize(config.sidebarLogoSize);
            if (config.sidebarLogoAlt) this.setSidebarLogoAlt(config.sidebarLogoAlt);
            if (config.sidebarLogoClassName) this.setSidebarLogoClassName(config.sidebarLogoClassName);
        },
    },
});

export const useGlobalLayoutRouteStore = defineStore('globalLayoutRoute', {
    state: (): LayoutRouteInterface => ({
        logoRedirectPath: null,
        settingsPath: null,
    }),

    actions: {
        setLogoRedirectPath(path: any) {
            this.logoRedirectPath = path;
        },
        setSettingsPath(path: any) {
            this.settingsPath = path;
        },
    },
});
