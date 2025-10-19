
/**
 *
 * @param dateString - Date string to parse
 * @returns - Parsed date
 *
 * mostly used for date picker in datatable
 */
export const parseDate = (dateString: string | undefined | null): Date | null => {
    if (!dateString) return null;
    const date = new Date(dateString);
    return isNaN(date.getTime()) ? null : date;
};
