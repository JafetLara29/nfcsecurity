import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/bower_components/jquery/dist/jquery.min.js',
                'resources/bower_components/jquery-ui/jquery-ui.min.js',
                'resources/assets/js/jquery.mCustomScrollbar.concat.min.js',
                'resources/assets/js/script.js'
            ],
            refresh: true,
        }),
    ],
});
