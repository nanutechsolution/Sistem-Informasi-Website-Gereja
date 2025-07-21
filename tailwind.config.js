import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    colors: {
        primary: { "50": "#eff6ff", "100": "#dbeafe", "200": "#bfdbfe", "300": "#93c5fd", "400": "#60a5fa", "500": "#3b82f6", "600": "#2563eb", "700": "#1d4ed8", "800": "#1e40af", "900": "#1e3a8a", "950": "#172554" }
    },
    theme: {
        extend: {
            transitionProperty: {
                'height': 'height',
                'spacing': 'margin, padding',
                'colors': 'background-color, border-color, color, fill, stroke',
                'opacity': 'opacity',
                'shadow': 'box-shadow',
                'transform': 'transform',
            },
            transitionDuration: {
                '200': '200ms',
                '300': '300ms',
                '500': '500ms',
            },
            fontFamily: { // Opsional: jika Anda ingin kustomisasi font
                sans: ['Figtree', 'sans-serif'], // Figtree sudah default dari Breeze
                // Tambahkan font lain jika Anda mengimpornya
            }
        },
    },

    plugins: [forms],
};
