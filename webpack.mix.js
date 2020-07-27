const mix = require('laravel-mix');

/** @see https://github.com/JaKXz/stylelint-webpack-plugin */
var StyleLintPlugin = require('stylelint-webpack-plugin');
require('laravel-mix-merge-manifest');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

const sections = [
    'scss',
    'js',
];

if (sections.includes(process.env.npm_config_section)) {
    require(`${__dirname}/webpack/${process.env.npm_config_section}.webpack.mix.js`);

    mix.webpackConfig({
        module: {
            rules: [
                {
                    enforce: 'pre',
                    test: /\.(js|vue)$/,
                    loader: 'eslint-loader',
                    exclude: /node_modules/,
                    options: {
                        fix: true,
                        quiet: false,
                        failOnWarning: true,
                        failOnError: true,
                    }
                }
            ]
        },
        plugins: [
            new StyleLintPlugin({
                fix: true,
                configFile: path.resolve('./.stylelintrc'),
                context: path.resolve(__dirname, 'resources/sass/' ),
                lintDirtyModulesOnly: false, // on vérifie seulement les fichiers modifiés : true|false
                emitErrors: true,
            }),
        ],
    });

    if (mix.inProduction()) {
        mix.options({ uglify: { uglifyOptions: { compress: { drop_console: true, } } } });
        mix.version();
    } else {
        mix.sourceMaps();
        mix.webpackConfig({
            devtool: 'inline-source-map'
        });
    }

    mix.mergeManifest();
}
