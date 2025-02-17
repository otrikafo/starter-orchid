import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import fs from 'fs';
export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
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
    devServer: {
        host: 'starter-orchid.local',
        https: true,
        key: fs.readFileSync('.certs/key.pem'),
        cert: fs.readFileSync('.certs/cert.pem'),
    },
});
