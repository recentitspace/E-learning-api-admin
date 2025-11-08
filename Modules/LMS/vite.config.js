import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig(
    {
        build: {
            outDir: '../../public/build-lms',
            emptyOutDir: true,
            manifest: true,
        },
        plugins: [
        laravel(
            {
                publicDirectory: '../../public',
                buildDirectory: 'build-lms',
                input: [
                __dirname + '/resources/assets/sass/app.scss',
                __dirname + '/resources/assets/js/app.js'
                ],
                refresh: true,
            }
        ),
    ],
    }
);

//export const paths = [
//    'Modules/LMS/resources/assets/sass/app.scss',
//    'Modules/LMS/resources/assets/js/app.js',
//];