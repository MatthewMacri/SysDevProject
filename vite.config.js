import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: ['resources/css/app.css', 'resources/js/app.js'],
      refresh: true,
    }),
  ],
  build: {
    rollupOptions: {
      input: 'resources/js/app.js', // Make sure this is correctly pointing to the entry JS file
    },
  },
});