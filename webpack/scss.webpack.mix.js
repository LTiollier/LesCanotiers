const mix = require('laravel-mix');

mix.sass('resources/sass/app.scss', 'public/css');

mix.browserSync({
    host: '127.0.0.1',
    proxy: process.env.APP_URL,
    open: false,
    files: [
        'app/**/*.php',
        'resources/views/**/*.php',
        'public/js/**/*.js',
        'public/css/**/*.css'
    ],
    watchOptions: {
        usePolling: true,
        interval: 500
    },
    port: 8019
});
