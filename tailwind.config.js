import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
        fontFamily: {
            sans: ['Rubik', 'ui-sans-serif', 'system-ui'],
            heading: ['Rubik', 'sans-serif'],
        },
        colors: {
            primary: '#0A1F44',
            primarySoft: '#E6EDFA',
            success: '#16A34A',
            successSoft: '#DCFCE7',
            danger: '#DC2626',
            dangerSoft: '#FEE2E2',
            muted: '#64748B',
            background: '#F8FAFC',
        }
        },
    },

    plugins: [forms],
};
