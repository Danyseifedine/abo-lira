import type { NavItem } from '@/core/types';

/**
 * Check if user can access a navigation item
 */
export const canAccessNavItem = (
    item: NavItem,
    userPermissions: string[],
    userRoles: string[]
): boolean => {
    // If no restrictions, allow access (including sections without permissions)
    if (!item.permission && !item.role && !item.permissions && !item.roles) {
        return true;
    }

    let hasRequiredPermission = true;
    let hasRequiredRole = true;

    // Check single permission
    if (item.permission) {
        hasRequiredPermission = userPermissions.includes(item.permission);
    }

    // Check multiple permissions (use requireAll flag to determine AND/OR logic)
    if (item.permissions && item.permissions.length > 0) {
        hasRequiredPermission = item.requireAll
            ? item.permissions.every(permission => userPermissions.includes(permission))
            : item.permissions.some(permission => userPermissions.includes(permission));
    }

    // Check single role
    if (item.role) {
        hasRequiredRole = userRoles.includes(item.role);
    }

    // Check multiple roles (use requireAll flag to determine AND/OR logic)
    if (item.roles && item.roles.length > 0) {
        hasRequiredRole = item.requireAll
            ? item.roles.every(role => userRoles.includes(role))
            : item.roles.some(role => userRoles.includes(role));
    }

    return hasRequiredPermission && hasRequiredRole;
};

/**
 * Filter navigation items based on user permissions and roles
 */
export const filterNavigation = (
    items: NavItem[],
    userPermissions: string[],
    userRoles: string[]
): NavItem[] => {
    return items
        .filter(item => canAccessNavItem(item, userPermissions, userRoles))
        .map(item => {
            if (item.children && item.children.length > 0) {
                const filteredChildren = filterNavigation(
                    item.children,
                    userPermissions,
                    userRoles
                );

                // If this is a section, keep it even if no children
                if (item.isSection) {
                    return { ...item, children: filteredChildren };
                }

                // For regular items with children, only keep if there are accessible children
                if (filteredChildren.length > 0) {
                    return { ...item, children: filteredChildren };
                }

                // If no accessible children, exclude this parent
                return null;
            }
            return item;
        })
        .filter((item): item is NavItem => item !== null);
};
