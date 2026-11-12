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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },

            colors: {
                // Superficies (tema oscuro, tomado de las referencias)
                canvas: '#0E0E13', // fondo de la página
                side:   '#121218', // barra lateral
                surface:'#17171F', // tarjetas, tablas, formularios
                raised: '#1F1F29', // inputs, hover, elementos elevados
                line:   '#2B2B37', // bordes y divisores

                // Texto
                ink:        '#F3F1F8',
                'ink-soft': '#B9B6C8',
                muted:      '#8683A0',

                // Marca: morado del logo de Tienda Clic
                brand: {
                    50:  '#F5EEFB',
                    100: '#EADCF7',
                    200: '#DCC4F0',
                    300: '#C9A5E6',
                    400: '#B58BDB', // tono claro del logo sobre fondo oscuro
                    500: '#8E4FC0', // acción principal
                    600: '#7A3DAA',
                    700: '#4F1A6C', // morado oscuro del logo
                    800: '#3A1352',
                    900: '#27093A',
                },

                // Estados
                ok:   '#3DD68C',
                warn: '#F5B544',
                bad:  '#F2616B',
            },

            borderRadius: {
                xl: '0.875rem',
            },

            boxShadow: {
                glow: '0 0 0 1px rgba(142,79,192,.35), 0 8px 24px -8px rgba(142,79,192,.45)',
            },
        },
    },

    plugins: [forms],
};
