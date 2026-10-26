import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/components/navbar.css',
                'resources/css/components/hero.css',
                'resources/css/components/sections.css',
                'resources/css/components/footer.css',
                'resources/css/components/cart.css',
                'resources/css/components/payment.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
