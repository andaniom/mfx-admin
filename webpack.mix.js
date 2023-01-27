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

mix.js('resources/vendor/jquery/jquery.js', 'public/vendor/jquery')
    .js('resources/vendor/jquery/jquery.min.js', 'public/vendor/jquery')
    // .js('resources/js/bootstrap.js', 'public/js')
    .js('resources/js/sb-admin-2.min.js', 'public/js')
    .js('resources/vendor/bootstrap/js/bootstrap.bundle.min.js', 'public/vendor/bootstrap/js/')
    .js('resources/vendor/jquery-easing/jquery.easing.min.js', 'public/vendor/jquery-easing')
    .postCss('resources/css/sb-admin-2.min.css', 'public/css')
    .postCss('resources/vendor/fontawesome-free/css/all.min.css', 'public/vendor/fontawesome-free/css');
