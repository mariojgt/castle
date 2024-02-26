import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import ReactivityTransform from '@vue-macros/reactivity-transform/vite'

export default defineConfig({
    plugins: [
        ReactivityTransform(),
        laravel([
            'resources/vendor/Castle/js/app.ts',
            'resources/vendor/Castle/sass/app.scss',
        ]),
          vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
            reactivityTransform: true
        }),
    ],
    build: {
        outDir: 'public/vendor/Castle',
        emptyOutDir: true,
        rollupOptions: {
            input: {
                app: 'resources/vendor/Castle/js/app.js',
                css: 'resources/vendor/Castle/sass/app.scss',
            },
        },
    },
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'localhost'
        }
    },
});
