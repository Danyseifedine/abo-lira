import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import type { SharedData } from '@/core/types';

export const useGuard = () => {
    const page = usePage<SharedData>();

    // Reactive user permissions and roles
    const userPermissions = computed(() => page.props.auth?.permissions || []);
    const userRoles = computed(() => page.props.auth?.roles || []);

    /**
     * Check if user has a specific permission
     */
    const hasPermission = (permission: string): boolean => {
        return userPermissions.value.includes(permission);
    };

    /**
     * Check if user has any of the specified permissions
     */
    const hasPermissions = (permissions: string[], requireAll = false): boolean => {
        if (permissions.length === 0) return true;

        return requireAll
            ? permissions.every(permission => hasPermission(permission))
            : permissions.some(permission => hasPermission(permission));
    };

    /**
     * Check if user has a specific role
     */
    const hasRole = (role: string): boolean => {
        return userRoles.value.includes(role);
    };

    const isSuperAdmin = computed(() => userRoles.value.includes('super-admin'));

    /**
     * Check if user has any of the specified roles
     */
    const hasRoles = (roles: string[], requireAll = false): boolean => {
        if (roles.length === 0) return true;

        return requireAll
            ? roles.every(role => hasRole(role))
            : roles.some(role => hasRole(role));
    };

    /**
     * Check if any user object has a specific role
     */
    const userHasRole = (user: any, role: string): boolean => {
        if (!user?.roles) return false;
        return Array.isArray(user.roles) 
            ? user.roles.some((r: any) => r.name === role || r === role)
            : false;
    };

    /**
     * Check if any user object has any of the specified roles
     */
    const userHasRoles = (user: any, roles: string[], requireAll = false): boolean => {
        if (!user?.roles || roles.length === 0) return false;
        
        return requireAll
            ? roles.every(role => userHasRole(user, role))
            : roles.some(role => userHasRole(user, role));
    };

    /**
     * Check if any user object is super admin
     */
    const userIsSuperAdmin = (user: any): boolean => {
        return userHasRole(user, 'super-admin');
    };

    /**
     * Convenient aliases
     */
    const can = hasPermission;
    const cannot = (permission: string): boolean => !hasPermission(permission);
    const is = hasRole;
    const isNot = (role: string): boolean => !hasRole(role);

    return {
        // State
        userPermissions,
        userRoles,

        // Core functions (for current user)
        hasPermission,
        hasPermissions,
        hasRole,
        hasRoles,
        isSuperAdmin,
        
        // Utility functions (for any user object)
        userHasRole,
        userHasRoles,
        userIsSuperAdmin,
        
        // Aliases
        can,
        cannot,
        is,
        isNot,
    };
};
