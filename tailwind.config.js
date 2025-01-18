import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		 './storage/framework/views/*.php',
		 './resources/**/*.blade.php',
		 './resources/**/*.js',
		 "./vendor/robsontenorio/mary/src/View/Components/**/*.php"
	],
    safelist: [
        'bg-red-400',
        'bg-blue-400',
        'bg-green-400',
        'badge-info',
        'badge-success',
        'badge-error',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [
		require("daisyui")
	],
    daisyui: {
        themes: ["light", "dark", "corporate"],
    },
};
