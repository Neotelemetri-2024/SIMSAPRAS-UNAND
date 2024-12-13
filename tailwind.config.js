import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

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
                unand: {
                    'primary-green': '#2E8B57',   // Sea Green - Warna Utama
                    'dark-green': '#1A5F3C',     // Hijau Gelap - Untuk kontras
                    'light-green': '#8FBC8F',    // Dark Sea Green - Untuk elemen kedua
                    'accent-green': '#3CB371',   // Medium Sea Green - Aksen
                    'soft-white': '#F4F6F6',     // Background ringan
                    'custom-gray': '#708090',             // Warna abu untuk netralitas
                    'text-dark': '#2C3E50',      // Warna teks utama
                    'dark-background': '#1C2833', // Background gelap
                    'dark-surface': '#2C3E50',   // Surface gelap
                },
            }
        },
    },

    plugins: [
        forms,
        require("flowbite/plugin")],
};
