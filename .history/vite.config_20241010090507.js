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
                'resources/css/the'
                'resources/js/create.js',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
