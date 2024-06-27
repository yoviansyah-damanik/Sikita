const { addDynamicIconSelectors } = require('@iconify/tailwind');
const { iconsPlugin, getIconCollections } = require("@egoist/tailwindcss-icons")

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'selector',
    content: [
        "./resources/**/*.blade.php",
        "./app/View/**/*.php",
    ],
    theme: {
        fontFamily: {
            'body': ['QuickSand', 'serif'],
        },
        extend: {
            colors: {
                'ocean-blue': {
                    50: '#eef3ff',
                    100: '#dfe9ff',
                    200: '#c6d4ff',
                    300: '#a3b8fe',
                    400: '#7e91fb',
                    500: '#606cf4',
                    600: '#4344e8',
                    700: '#3735cd',
                    800: '#2e2ea5',
                    900: '#2f318b',
                    950: '#1a1a4c'
                },
                'primary': {
                    50: '#f3f8fc',
                    100: '#e7f2f7',
                    200: '#c7e2ed',
                    300: '#9acddf',
                    400: '#64b2cc',
                    500: '#4098b7',
                    600: '#2f7c9a',
                    700: '#27647d',
                    800: '#245468',
                    900: '#224758',
                    950: '#172e3a',
                },
                green: {
                    50: '#edfff5',
                    100: '#d6ffea',
                    200: '#afffd5',
                    300: '#71ffb7',
                    400: '#2dfb90',
                    500: '#02e570',
                    600: '#00bf59',
                    700: '#009b4c',
                    800: '#06753d',
                    900: '#085f34',
                    950: '#00361b',
                },
                yellowSmooth: {
                    50: '#fdffe7',
                    100: '#f8ffc1',
                    200: '#f5ff86',
                    300: '#f7ff41',
                    400: '#fffe0d',
                    500: '#fff000',
                    600: '#d1b300',
                    700: '#a68102',
                    800: '#89640a',
                    900: '#74520f',
                    950: '#442c04',
                },
                lotus: {
                    50: '#fcf4f4',
                    100: '#f9e8e7',
                    200: '#f5d4d3',
                    300: '#edb6b4',
                    400: '#e08c89',
                    500: '#d16562',
                    600: '#bc4a46',
                    700: '#9d3b38',
                    800: '#833331',
                    900: '#743331',
                    950: '#3b1514',
                },
            },
        },
    },
    safelist: [
        'swal2-container'
    ],
    plugins: [
        // Iconify plugin
        addDynamicIconSelectors(),
        iconsPlugin({
            // Select the icon collections you want to use
            // You can also ignore this option to automatically discover all individual icon packages you have installed
            // If you install @iconify/json, you should explicitly specify the collections you want to use, like this:
            collections: getIconCollections(['solar', 'ph']),
            // If you want to use all icons from @iconify/json, you can do this:
            // collections: getIconCollections("all"),
            // and the more recommended way is to use `dynamicIconsPlugin`, see below.
        }),
    ],
}

