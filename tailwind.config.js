import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './node_modules/flowbite/**/*.js',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primarni: '#0D3453',
                primarniDarker: '#0a2942',
                sekundarni: '#B0B7BD',
                jemnepozor: '#C89A92',
                pozor: '#67352C',
            },
        },
    },
    plugins: [
        forms,
        typography,
        require('flowbite/plugin'),
    ],
};
