import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
const plugin = require('tailwindcss/plugin')

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            textShadow: {
                sm: '0 0 2px var(--tw-shadow-color)',
                DEFAULT: '0 0 4px var(--tw-shadow-color)',
                lg: '0 0 16px var(--tw-shadow-color)',
            },
        },
    },

    plugins: [forms, typography,
        plugin(function ({ matchUtilities, theme }) {
          matchUtilities(
          {
              'text-shadow': (value) => ({
                textShadow: value,
            }),
          },
          { values: theme('textShadow') }
          )
      }),
        ],
};
