const mix = require('laravel-mix');

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

// require('resolve-url-loader'); //error
// mix.alias({
//     '@': '/resources/js',
//     '~': '/resources/sass',
//     '@components': '/resources/js/components',
// });

mix.webpackConfig({
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {
            '@': '/resources/js'
        },
    },
})

mix.js('resources/js/app/index.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
