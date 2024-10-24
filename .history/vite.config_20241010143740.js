import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/accueil.css',   
                'resources/css/create.css',            
                'resources/css/fontawesome.css',
                
                'resources/css/main.css',
                'resources/js/create.js',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
