import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/panier.css',
                'resources/css/accueil.css',
                'resources/css/footer.css',
                'resources/css/create.css',
                'resources/css/slick-theme.css',
                'resources/css/slick-theme.min.css',
                'resources/css/slick.min.css',
                'resources/css/fontawesome.css',
                'resources/css/fontawesome.min.css',
                'resources/css/templatemo.css',
                'resources/css/templatemo.min.css',
                'resources/css/bootstrap.min.css',
                'resources/css/nav.css',
                'resources/js/create.js',
                'resources/js/app.js',
                'resources/js/jquery-1.11.0.min.js',
                'resources/js/jquery-migrate-1.2.1.min.js',
                'resources/js/bootstrap.bundle.min.js',
                'resources/js/templatemo.js',
                'resources/js/custom.js',
                'resources/js/panier/viderPanier.js',
                'resources/js/panier/viderArticlePanier.js',
                'resources/js/panier/changerQuantiter.js',
                'resources/js/panier/passerCommande.js',
            ],
            refresh: true,
        }),
    ],
});
