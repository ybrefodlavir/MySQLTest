/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                merah: "#E65F5C",
                biru: "#2AB7CA",
                kuning: "#FED766",
                hijau: "#23F0C7",
            },
        },
    },
    plugins: [],
};
