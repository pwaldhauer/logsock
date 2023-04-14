/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./app/**/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./resources/vendor/**/*.blade.php",
        './vendor/wire-elements/modal/resources/views/*.blade.php',
        "./vendor/pwaio/pwablui/resources/**/*.blade.php",
    ],
    theme: {
        extend: {
            backgroundColor: ({ theme }) => ({
                primary:  theme('colors.teal'),
            }),
            ringColor: ({ theme }) => ({
                primary:  theme('colors.teal'),
            }),
            textColor: ({ theme }) => ({
                primary:  theme('colors.teal'),
            }),
            borderColor: ({ theme }) => ({
                primary:  theme('colors.teal'),
            }),
            fill: ({ theme }) => ({
                primary:  theme('colors.teal'),
            })
        },
    },
    safelist: [
        'sm:max-w-xs',
        'sm:max-w-2xl',
        'sm:max-w-3xl',
        'sm:max-w-md',
        'md:max-w-xl',
        'lg:max-w-3xl',
    ],
    plugins: [],
}
