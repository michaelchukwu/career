const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    mode: 'jit',
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            backgroundImage: {
                clear: "url('/bg.jpg')"
            },
            textColor:{
                car: "#00b2a9",
                lnk: "#ea5498"
            },
            backgroudColor: theme =>({
                clear1:"#232a34",
                car:"#00b2a9"
            })
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
