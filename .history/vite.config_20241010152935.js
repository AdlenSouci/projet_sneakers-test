import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/accueil.css',
                'resources/css/create.css',
                'resources/css/nav.css',
                'resources/js/create.js',
                'resources/js/app.js',
                'resources/js/jquery-1.11.0.min.js',
                'resources/js/jquery-migrate-1.2.1.min.js,
                'resources/js/bootstrap.bundle.min.js',
                'resources/js/templatemo.js',
                'resources/js/custom.js',
            ],
            refresh: true,
        }),
    ],
});
