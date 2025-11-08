/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./Modules/LMS/resources/views/components/**/*.blade.php",
        "./Modules/LMS/resources/views/theme/**/*.blade.php",
        "./Modules/LMS/resources/views/theme/**/*.blade.php",
        "./Modules/LMS/resources/themes/**/*.blade.php",
        "./public/lms/frontend/assets/js/*.js",
    ],
    darkMode: "selector",
    mode: "jit",
    theme: {
        container: {
            center: true,
            padding: {
                DEFAULT: "12px",
            },
        },
        fontFamily: {
            mulish: "var(--font-primary)",
            secondary: "var(--font-secondary)",
            remix: ["remixicon"],
        },
        screens: {
            xl: "1320px",
            lg: "1024px",
            md: "768px",
            sm: "640px",
        },
        extend: {
            colors: {
                heading: "rgb(from var(--color-heading) r g b / <alpha-value>)",
                primary: {
                    DEFAULT:
                        "rgb(from var(--color-primary) r g b / <alpha-value>)",
                    50: "rgb(from var(--color-primary-50) r g b / <alpha-value>)",
                    100: "rgb(from var(--color-primary-100) r g b / <alpha-value>)",
                    200: "rgb(from var(--color-primary-200) r g b / <alpha-value>)",
                    300: "rgb(from var(--color-primary-300) r g b / <alpha-value>)",
                    400: "rgb(from var(--color-primary-400) r g b / <alpha-value>)",
                    500: "rgb(from var(--color-primary-500) r g b / <alpha-value>)",
                    600: "rgb(from var(--color-primary-600) r g b / <alpha-value>)",
                },
                secondary: {
                    DEFAULT:
                        "rgb(from var(--color-secondary) r g b / <alpha-value>)",
                },
                section: {
                    DEFAULT:
                        "rgb(from var(--color-section) r g b / <alpha-value>)",
                },
                warning: {
                    DEFAULT: "#FFA305",
                },
                danger: {
                    DEFAULT: "#FF4626",
                },
                success: {
                    DEFAULT: "#66CC33",
                },
                info: {
                    DEFAULT: "#498CFF",
                },
                disable: {
                    DEFAULT: "#999",
                },
                border: {
                    DEFAULT: "#1118271A",
                },
            },
            gridTemplateColumns: {
                13: "repeat(13, minmax(0, 1fr))",
            },
            spacing: {
                header: "80px",
            },
            backgroundImage: {
                "text-highlighter":
                    "url('../../assets/images/icons/text-highlighter.svg')",
                video: "linear-gradient(90deg, #44FF9A -0.55%, #44B0FF 22.86%, #8B44FF 48.36%, #F64 73.33%, #EBFF70 99.34%)",
                header: "linear-gradient(90deg, #F7F4FF 50%, #fff 50%)",
                "overlay-gradient":
                    "linear-gradient(180deg, rgba(17, 24, 39, 0.00) 0%, #111827 100%)",
                "banner-four":
                    "linear-gradient(90deg, #3C5F3F 0%, #16413B 100%)",
                "video-overlay":
                    "linear-gradient(91deg, rgba(0, 162, 100, 0.60) 0.45%, rgba(0, 162, 100, 0.20) 83.84%)",
                "pricing-three":
                    "linear-gradient(180deg, rgba(239, 244, 224, 0.00) 0%, #EFF4E0 100%)",
                "pricing-five":
                    "linear-gradient(90deg, #FDFFEA 0%, #E4FAEC 100%)",
            },
            keyframes: {
                fade: {
                    "0%, 50%": { opacity: "0" },
                    "100%": { opacity: "1" },
                },
                pulse: {
                    "0%": { transform: "scale(0.32)", opacity: ".8" },
                    "50%": { opacity: "1" },
                    "85%, 100%": { transform: "scale(1)", opacity: "0" },
                },
                reset: {
                    "0%": { top: "-5px", opacity: "0" },
                    "100%": { top: "0", opacity: "1" },
                },
            },
            boxShadow: {
                secondary: "30px 30px var(--color-secondary)",
                "pricing-four": "0px 0px 1px 1px rgba(3, 6, 17, 0.12)",
                "pricing-five": "0px 1px 2px 0px rgba(14, 27, 46, 0.10)",
                "pricing-five-hover": "0px 2px 40px 0px rgba(3, 6, 17, 0.14)",
            },
            animation: {
                fade: "fade 0.5s ease forwards",
                pulse: "pulse 2s ease-in-out infinite",
                reset: "reset 0.3s ease forwards",
            },
            zIndex: {
                backdrop: 149,
                modal: 150,
            },
        },
    },
    plugins: [require("tailwindcss-rtl")],
};
