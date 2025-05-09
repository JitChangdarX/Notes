import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.jsx'], // Include React and CSS files
            refresh: true,
        }),
        react(), // Enable React plugin
    ],
    server: {
        proxy: {
            '/': 'http://localhost:8080',  // Proxy requests to Laravel running on port 8080
        },
    },
});
