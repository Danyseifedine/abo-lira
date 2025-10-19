
import { usePage } from '@inertiajs/vue3';

// Simple translation function using Inertia shared data
// NOTE: This function can only be used within Vue component setup context
export function __(key: string, replacements: Record<string, string | number> = {}): string {
    const page = usePage();
    const translations = page.props.translations as Record<string, string> || {};

    let translation = translations[key] || key;

    // Handle replacements like :count, :name, etc.
    Object.entries(replacements).forEach(([placeholder, value]) => {
        const pattern = new RegExp(`:${placeholder}\\b`, 'g');
        translation = translation.replace(pattern, String(value));
    });

    return translation;
}
