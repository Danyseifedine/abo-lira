import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

interface Setting {
    id: number;
    key: string;
    value: string;
    hint: string;
}

interface SettingsGroups {
    [group: string]: Setting[];
}

interface PageProps {
    settings?: SettingsGroups;
    [key: string]: unknown;
}

/**
 * Composable to access global application settings
 * Settings are automatically cached on the backend and shared via Inertia
 */
export function useSettings() {
    const page = usePage<PageProps>();

    // Get all settings grouped by category
    const settings = computed(() => page.props.settings || {});

    // Get a specific setting value by key
    const getSetting = (key: string, defaultValue: string = ''): string => {
        const allSettings = settings.value;

        for (const group of Object.values(allSettings)) {
            const setting = group.find((s) => s.key === key);
            if (setting) {
                return setting.value;
            }
        }

        return defaultValue;
    };

    // Get all settings in a specific group
    const getSettingsByGroup = (group: string): Setting[] => {
        return settings.value[group] || [];
    };

    // Get a setting value as a boolean
    const getBooleanSetting = (key: string, defaultValue: boolean = false): boolean => {
        const value = getSetting(key, String(defaultValue));
        return value === 'true' || value === '1';
    };

    // Get a setting value as a number
    const getNumberSetting = (key: string, defaultValue: number = 0): number => {
        const value = getSetting(key, String(defaultValue));
        return Number(value) || defaultValue;
    };

    // Convenient getters for common settings
    const appName = computed(() => getSetting('app_name', 'Application'));
    const appDescription = computed(() => getSetting('app_description', ''));
    const mailFromName = computed(() => getSetting('mail_from_name', ''));
    const mailFromAddress = computed(() => getSetting('mail_from_address', ''));
    const itemsPerPage = computed(() => getNumberSetting('items_per_page', 25));
    const timezone = computed(() => getSetting('timezone', 'UTC'));
    const mustVerifyEmail = computed(() => getBooleanSetting('must_verify_email_on_registration', false));

    return {
        // Raw settings
        settings,

        // Getters
        getSetting,
        getSettingsByGroup,
        getBooleanSetting,
        getNumberSetting,

        // Common settings
        appName,
        appDescription,
        mailFromName,
        mailFromAddress,
        itemsPerPage,
        timezone,
        mustVerifyEmail,
    };
}

