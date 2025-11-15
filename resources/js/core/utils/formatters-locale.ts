import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

/**
 * Locale mapping for Intl API
 */
const localeMap: Record<string, string> = {
    en: 'en-US',
    ar: 'ar-SA',
};

/**
 * Get current locale from Inertia page props
 */
export function useLocale() {
    const page = usePage();
    return computed(() => (page.props.locale as string) || 'en');
}

/**
 * Get mapped locale for Intl API
 */
export function useIntlLocale() {
    const currentLocale = useLocale();
    return computed(() => localeMap[currentLocale.value] || 'en-US');
}

/**
 * Format date - always in English format
 * @param date - Date string or Date object
 * @param options - Intl.DateTimeFormat options
 */
export function useFormatDate() {
    return (date: string | Date, options?: Intl.DateTimeFormatOptions) => {
        const defaultOptions: Intl.DateTimeFormatOptions = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hour12: true,
        };

        const finalOptions = options || defaultOptions;

        // Always use English locale for dates
        return new Date(date).toLocaleDateString('en-US', finalOptions);
    };
}

/**
 * Format date with both Gregorian and Hijri dates for Arabic
 * @param date - Date string or Date object
 */
export function useFormatDateWithBoth() {
    const currentLocale = useLocale();
    const intlLocale = useIntlLocale();

    return (date: string | Date) => {
        const dateObj = new Date(date);
        
        if (currentLocale.value === 'ar') {
            // Show both Gregorian and Hijri for Arabic
            const gregorian = dateObj.toLocaleDateString('ar-SA', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                numberingSystem: 'arab',
            });
            
            try {
                const hijri = new Intl.DateTimeFormat('ar-SA-u-ca-islamic', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    calendar: 'islamic',
                    numberingSystem: 'arab',
                }).format(dateObj);
                
                return `${gregorian} (${hijri})`;
            } catch (e) {
                return gregorian;
            }
        }

        // For English, just show the date normally
        return dateObj.toLocaleDateString(intlLocale.value, {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        });
    };
}

/**
 * Format currency - simple format like $70.00
 * @param amount - Amount to format
 */
export function useFormatCurrency() {
    return (amount: string | number) => {
        const numAmount = Number(amount);
        const formatted = numAmount.toFixed(2);
        return `$${formatted}`;
    };
}

/**
 * Format number with locale support
 * @param value - Number to format
 * @param options - Intl.NumberFormat options
 */
export function useFormatNumber() {
    const intlLocale = useIntlLocale();

    return (value: string | number, options?: Intl.NumberFormatOptions) => {
        return new Intl.NumberFormat(intlLocale.value, options).format(Number(value));
    };
}

/**
 * Format relative time (e.g., "2 hours ago", "منذ ساعتين")
 * @param date - Date string or Date object
 */
export function useFormatRelativeTime() {
    const intlLocale = useIntlLocale();

    return (date: string | Date) => {
        const now = new Date();
        const targetDate = new Date(date);
        const diffInSeconds = Math.floor((now.getTime() - targetDate.getTime()) / 1000);

        const rtf = new Intl.RelativeTimeFormat(intlLocale.value, { numeric: 'auto' });

        if (diffInSeconds < 60) {
            return rtf.format(-diffInSeconds, 'second');
        } else if (diffInSeconds < 3600) {
            return rtf.format(-Math.floor(diffInSeconds / 60), 'minute');
        } else if (diffInSeconds < 86400) {
            return rtf.format(-Math.floor(diffInSeconds / 3600), 'hour');
        } else if (diffInSeconds < 604800) {
            return rtf.format(-Math.floor(diffInSeconds / 86400), 'day');
        } else if (diffInSeconds < 2592000) {
            return rtf.format(-Math.floor(diffInSeconds / 604800), 'week');
        } else if (diffInSeconds < 31536000) {
            return rtf.format(-Math.floor(diffInSeconds / 2592000), 'month');
        } else {
            return rtf.format(-Math.floor(diffInSeconds / 31536000), 'year');
        }
    };
}

