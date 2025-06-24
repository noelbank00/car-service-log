import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import fs from 'fs';
import laravel from 'laravel-vite-plugin';
import path from 'path';
import { defineConfig } from 'vite';

const host = 'car-service-log.develop';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        tailwindcss(),
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
        },
    },
    server: {
        host: host,
        strictPort: true,
        port: parseInt(process.env.VITE_PORT) || 5173,
        hmr: {
            clientPort: parseInt(process.env.VITE_PORT) || 5173,
            host: host,
        },
        https: {
            key: fs.readFileSync(`/var/ssl/${host}.key`),
            cert: fs.readFileSync(`/var/ssl/${host}.crt`),
        },
        cors: {
            origin: `https://${host}`,
            credentials: true,
        },
    },
});
