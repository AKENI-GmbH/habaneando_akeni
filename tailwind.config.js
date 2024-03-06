import preset from './vendor/filament/support/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './vendor/filament/**/*.blade.php',
        "./resources/views/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/**/*.blade.php",
        "./resources/views/**/**/**/*.blade.php",
        "./resources/views/**/**/**/**/*.blade.php",
        "./resources/views/**/**/**/**/**/*.blade.php",
        "./resources/views/**/**/*.blade.php",
        "./resources/js/**/*.js",
    ],

    safelist: [
        /grid-cols-(\d+)/,
        /col-span-(\d+|full)/,
        /(sm|md|lg|xl):col-span-(\d+|full)/,
        /(sm|md|lg|xl):grid-cols-(\d+)/,
    ],

    theme: {
        extend: {
            width: {
                100: "25rem",
                104: "26rem",
                108: "27rem",
                112: "28rem",
                116: "29rem",
                120: "30rem",
                124: "31rem",
                128: "32rem",
                132: "33rem",
                136: "34rem",
                140: "35rem",
                150: "40rem",
                160: "45rem",
                170: "50rem",
                180: "55rem",
            },
            height: {
                120: "30rem",
                130: "34rem",
            },
            gridColumn: {
                2: "2",
                3: "3",
            },
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/aspect-ratio"),
        require("@tailwindcss/typography"),
    ],
}
