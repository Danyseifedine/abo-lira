/**
 * Convert value to boolean
 * @param value - Value to convert
 * @returns Boolean value
 *
 * mostly used for toggle column in datatable
 */
export function convertToBoolean(value: any) {
    if (value === null || value === undefined) return true;
    if (typeof value === 'boolean') return value;
    if (typeof value === 'number') return value === 1;
    if (typeof value === 'string') return value === '1' || value.toLowerCase() === 'true';
    return !!value;
}

