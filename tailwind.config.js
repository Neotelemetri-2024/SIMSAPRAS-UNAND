import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Poppins", "Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "modal-backdrop": "rgba(0, 0, 0, 0.5)", // Tambahkan ini
            },
            backgroundColor: {
                "modal-backdrop": "rgba(0, 0, 0, 0.5)",
            },
        },
    },

    plugins: [forms, require("flowbite/plugin")],
};
