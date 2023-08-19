import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import dotenv from 'dotenv';

dotenv.config();

export default defineConfig({
    define: {
        VITE_PUSHER_APP_CLUSTER : `"${process.env.VITE_PUSHER_APP_CLUSTER}"`,
        VITE_PUSHER_APP_KEY : `"${process.env.VITE_PUSHER_APP_KEY}"`,
        VITE_PUSHER_HOST : `"${process.env.VITE_PUSHER_HOST}"`,
        VITE_PUSHER_PORT : `"${process.env.VITE_PUSHER_PORT}"`,
        VITE_PUSHER_SCHEME : `"${process.env.VITE_PUSHER_SCHEME}"`,
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});
