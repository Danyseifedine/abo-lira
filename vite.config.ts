import vue from '@vitejs/plugin-vue';
import autoprefixer from 'autoprefixer';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import tailwindcss from 'tailwindcss';
import { resolve } from 'node:path';
import { defineConfig } from 'vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
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
            '@': path.resolve(__dirname, './resources/js'),
            '@core': path.resolve(__dirname, './resources/js/core'),
            '@modules': path.resolve(__dirname, './resources/js/modules'),
            '@shared': path.resolve(__dirname, './resources/js/shared'),
            '@common': path.resolve(__dirname, './resources/js/common'),
            '@ui': path.resolve(__dirname, './resources/js/shared/ui'),
            '@pages': path.resolve(__dirname, './resources/js/pages'),
            '@guard': path.resolve(__dirname, './resources/js/guard'),
            '@lang': path.resolve(__dirname, './resources/js/lang'),
            'ziggy-js': resolve(__dirname, 'vendor/tightenco/ziggy'),
        },
    },
    css: {
        postcss: {
            plugins: [tailwindcss, autoprefixer],
        },
    },
});
