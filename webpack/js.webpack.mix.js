const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js/admin');

/**
 * Extract
 */
mix.extract([
    'vue',
    'lodash',
    'vuetify',
    'axios',
]);

mix.browserSync({
    host: '127.0.0.1',
    proxy: process.env.APP_URL,
    open: true,
    files: [
        'app/**/*.php',
        'resources/views/**/*.php',
        'public/js/*.js',
        'public/*.js',
        'public/css/*.css'
    ],
    watchOptions: {
        usePolling: true,
        interval: 500
    }
});

mix.webpackConfig({
    output: {
        chunkFilename: mix.inProduction() ? "[name].js?id=[chunkhash]" : "[name].js",
    }
});
