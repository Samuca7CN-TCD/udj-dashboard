const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js').postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ]).sass('node_modules/materialize-css/sass/materialize.scss', 'public/css/materialize.css')
    .scripts('node_modules/jquery/dist/jquery.min.js', 'public/js/jquery.js')
    .scripts('node_modules/materialize-css/dist/js/materialize.min.js', 'public/js/materialize.js')
    .scripts('node_modules/chart.js/dist/chart.min.js', 'public/js/chart.js');