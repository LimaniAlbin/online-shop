import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: [
                'resources/css/admin/app.css',
                'resources/js/admin/admin.js',
                'resources/js/admin/scss/vertical-layout-light/style.scss',
                'resources/js/client/client.js',
                'resources/css/client/client.css',
                'resources/css/client/boostrap.min.css',
                'resources/css/client/templatemo.css',

            ],
            refresh: true,
        }),
    ],
});
