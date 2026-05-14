/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./**/*.{html,php}"],
    theme: {
        extend: {
            fontFamily: {
                newsreader: ['Newsreader', 'Georgia', 'serif'],
                inter: ['Inter', 'sans-serif'],
                code: ['Source Code Pro', 'monospace'],
            },
        }
    },
    plugins: [],
}