import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  server: {
    port: 5173,
    host: '127.0.0.1', // Cambiar de localhost a 127.0.0.1
    strictPort: true,
    cors: true,
    headers: {
      'Access-Control-Allow-Origin': '*',
    }
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});