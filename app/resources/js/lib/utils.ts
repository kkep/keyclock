import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function dateFormatter(dateString: string) {
    return dateString ? (new Date(dateString)).toLocaleString() : dateString;
}

export function debounceTime(callback: any, delay: number): (...args: any[]) => void {
    let timeout: number;

    return function (...args: any[]) {
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            callback.apply(this, args);
        }, delay);
    };
}
