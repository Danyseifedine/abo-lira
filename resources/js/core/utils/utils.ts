import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';


/**
 * Merge class names
 * @param inputs - Class names
 * @returns Merged class names
 */
export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}
