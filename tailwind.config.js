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
                "primary-fixed": "#cfe5ff",
                "on-tertiary-container": "#343434",
                "on-tertiary-fixed": "#1b1c1c",
                "on-secondary-fixed": "#1a1c1c",
                "background": "#131313",
                "tertiary-fixed-dim": "#c8c6c5",
                "tertiary": "#c8c6c5",
                "surface-tint": "#98cbff",
                "primary": "#98cbff",
                "surface-bright": "#3a3939",
                "on-error": "#690005",
                "on-background": "#e5e2e1",
                "surface-variant": "#353534",
                "on-primary": "#003354",
                "primary-fixed-dim": "#98cbff",
                "on-primary-fixed": "#001d33",
                "tertiary-fixed": "#e4e2e1",
                "surface-container-lowest": "#0e0e0e",
                "tertiary-container": "#9e9c9c",
                "inverse-primary": "#00629d",
                "on-primary-fixed-variant": "#004a77",
                "on-surface-variant": "#bec7d4",
                "error-container": "#93000a",
                "on-secondary": "#2f3131",
                "error": "#ffb4ab",
                "inverse-surface": "#e5e2e1",
                "on-secondary-fixed-variant": "#454747",
                "surface": "#131313",
                "on-secondary-container": "#b5b5b5",
                "secondary": "#c6c6c6",
                "outline-variant": "#3f4852",
                "surface-container": "#201f1f",
                "on-primary-container": "#00375a",
                "on-tertiary-fixed-variant": "#474746",
                "secondary-fixed": "#e2e2e2",
                "secondary-fixed-dim": "#c6c6c6",
                "on-surface": "#e5e2e1",
                "surface-container-low": "#1c1b1b",
                "inverse-on-surface": "#313030",
                "surface-container-highest": "#353534",
                "on-error-container": "#ffdad6",
                "primary-container": "#00a3ff",
                "on-tertiary": "#303030",
                "outline": "#88919d",
                "surface-dim": "#131313",
                "secondary-container": "#454747",
                "surface-container-high": "#2a2a2a"
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
