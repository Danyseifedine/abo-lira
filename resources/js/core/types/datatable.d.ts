/**
 * Reusable DataTable types to reduce boilerplate across all datatable implementations
 */

/**
 * Standard Laravel pagination response structure
 * Use this for all paginated API responses
 */
export interface PaginatedResponse<T = any> {
    data: T[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    from: number;
    to: number;
}

/**
 * Standard DataTable filter parameters
 * Extend this interface for custom filters
 */
export interface DataTableFilters {
    search?: string;
    sort?: string;
    direction?: 'asc' | 'desc';
    per_page?: number;
    [key: string]: any;
}

/**
 * Props structure for pages with datatable
 * Generic T represents your data model (e.g., User, Post)
 * Generic F represents additional filters (defaults to empty object)
 */
export interface DataTablePageProps<T = any, F extends Record<string, any>> {
    data: PaginatedResponse<T>;
    filters: DataTableFilters & F;
}
