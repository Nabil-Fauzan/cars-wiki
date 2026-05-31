import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import containerQueries from '@tailwindcss/container-queries';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                "primary-fixed": "#fbbf24",
                "on-tertiary-container": "#0f172a",
                "on-tertiary-fixed": "#0f172a",
                "on-secondary-fixed": "#000000",
                "background": "#0a0c10",
                "tertiary-fixed-dim": "#94a3b8",
                "tertiary": "#cbd5e1",
                "surface-tint": "#f59e0b",
                "primary": "#f59e0b",
                "surface-bright": "#334155",
                "on-error": "#ffffff",
                "on-background": "#f1f5f9",
                "surface-variant": "#1e293b",
                "on-primary": "#ffffff",
                "primary-fixed-dim": "#f59e0b",
                "on-primary-fixed": "#ffffff",
                "tertiary-fixed": "#cbd5e1",
                "surface-container-lowest": "#050505",
                "tertiary-container": "#e2e8f0",
                "inverse-primary": "#fbbf24",
                "on-primary-fixed-variant": "#ffffff",
                "on-surface-variant": "#94a3b8",
                "error-container": "#7f1d1d",
                "on-secondary": "#000000",
                "error": "#ef4444",
                "inverse-surface": "#f1f5f9",
                "on-secondary-fixed-variant": "#ffffff",
                "surface": "#1a1d23",
                "on-secondary-container": "#ffffff",
                "secondary": "#cbd5e1",
                "outline-variant": "#334155",
                "surface-container": "#1a1d23",
                "on-primary-container": "#ffffff",
                "on-tertiary-fixed-variant": "#0f172a",
                "secondary-fixed": "#f1f5f9",
                "secondary-fixed-dim": "#cbd5e1",
                "on-surface": "#f1f5f9",
                "surface-container-low": "#0f172a",
                "inverse-on-surface": "#0f172a",
                "surface-container-highest": "#334155",
                "on-error-container": "#fca5a5",
                "primary-container": "#b45309",
                "on-tertiary": "#0f172a",
                "outline": "#475569",
                "surface-dim": "#0a0c10",
                "secondary-container": "#334155",
                "surface-container-high": "#1e293b"
            },
            borderRadius: {
                "DEFAULT": "0.125rem",
                "lg": "0.25rem",
                "xl": "0.5rem",
                "full": "0.75rem"
            },
            spacing: {
                "stack-md": "32px",
                "container-max": "1440px",
                "gutter": "24px",
                "margin-page": "64px",
                "unit": "8px",
                "stack-sm": "16px",
                "stack-lg": "64px"
            },
            fontFamily: {
                "headline-xl": ["Metropolis", "sans-serif"],
                "label-caps": ["Metropolis", "sans-serif"],
                "headline-md": ["Metropolis", "sans-serif"],
                "headline-lg": ["Metropolis", "sans-serif"],
                "body-md": ["Inter", "sans-serif"],
                "body-lg": ["Inter", "sans-serif"],
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            fontSize: {
                "headline-xl": ["48px", {"lineHeight": "1.1", "letterSpacing": "-0.04em", "fontWeight": "800"}],
                "label-caps": ["12px", {"lineHeight": "1.0", "letterSpacing": "0.1em", "fontWeight": "800"}],
                "headline-md": ["24px", {"lineHeight": "1.3", "letterSpacing": "0em", "fontWeight": "700"}],
                "headline-lg": ["32px", {"lineHeight": "1.2", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                "body-md": ["16px", {"lineHeight": "1.6", "letterSpacing": "0.01em", "fontWeight": "400"}],
                "body-lg": ["18px", {"lineHeight": "1.6", "letterSpacing": "0em", "fontWeight": "400"}]
            }
        },
    },
    plugins: [forms, containerQueries],
};
