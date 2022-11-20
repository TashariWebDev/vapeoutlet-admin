const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import("tailwindcss").Config} */
module.exports = {
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/views/**/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontSize: {
                xxs: [".50rem", "1rem"],
            },
            fontFamily: {
                sans: ["Helvetica Neue", ...defaultTheme.fontFamily.sans],
            },
            animation: {
                "spin-slow": "spin 3s linear infinite",
                "spin-slower": "spin 5s linear infinite",
            },
        },
    },

    plugins: [require("@tailwindcss/forms")],
};
