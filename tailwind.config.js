import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],
    safelist: [
        'hover:bg-gray-300',
        'hover:bg-gray-700',
        'hover:text-indigo-700',
        'hover:bg-indigo-800',
        'bg-gray-50',
        'bg-gray-800',
        'w-72',
        'w-60',
        'w-80',
        'w-32',
        'w-24',
        'w-36',
        'w-44',
        // Добавьте сюда все hover-классы из colorArray
    ],
    theme: {
        extend: {
            fontFamily: {
                Verdana: ['Verdana'],
            },
        },
    },

    plugins: [forms],
};
