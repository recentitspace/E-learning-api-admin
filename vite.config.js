import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel([
            // "public/lms/assets/css/vendor/toastr.min.css",
            // "public/lms/frontend/assets/vendor/css/swiper-bundle.min.css",
            // "public/lms/frontend/assets/vendor/js/lozad.min.js",
            // "public/lms/frontend/assets/css/output.min.css",
            // "public/lms/frontend/assets/vendor/js/jquery-3.7.1.min.js",
            // "public/lms/frontend/assets/vendor/js/swiper-bundle.min.js",
            // "public/lms/frontend/assets/js/slider.js",
            // "public/lms/frontend/assets/js/tab.js",
            // "public/lms/assets/js/vendor/toastr.min.js",
            // "public/lms/frontend/assets/js/main.js",
            // "public/lms/frontend/assets/js/custom.js",
        ]),
    ],
});
