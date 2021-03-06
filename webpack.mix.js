let mix = require('laravel-mix');
let WebpackRTLPlugin = require('webpack-rtl-plugin');

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



mix.sass('resources/assets/sass/frontend/app.scss', 'public/css/frontend.css')
    .sass('resources/assets/sass/backend/app.scss', 'public/css/backend.css')
 //   .css('resources/assets/sass/forntend/all-landing.css', 'public/css/all-landing.css')
    .js([
        'resources/assets/js/frontend/app.js',
        'resources/assets/js/plugin/sweetalert/sweetalert.min.js',
        'resources/assets/js/plugins.js',
        'resources/assets/js/smoothscroll.js',
        'node_modules/jquery/dist/jquery.min.js'
    ], 'public/js/frontend.js')
    .js([
        'resources/assets/js/backend/app.js',
        'resources/assets/js/plugin/sweetalert/sweetalert.min.js',
        'resources/assets/js/plugins.js',
        'resources/assets/js/smoothscroll.js',
        'node_modules/jquery/dist/jquery.min.js'
    ], 'public/js/backend.js')
    .js([
        'resources/assets/js/plugin/icheck.min.js',
        'resources/assets/js/plugins.js',
        'resources/assets/js/frontend/login.js'
    ], 'public/js/login.js')
   /* .js([
        'resources/assets/js/app-landing.js',
    ], 'public/js/app-landing.js')*/
    .webpackConfig({
        plugins: [
            new WebpackRTLPlugin('/css/[name].rtl.css')
        ]
    });



if(mix.inProduction){
    mix.version();
}


