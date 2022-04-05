const mix = require('laravel-mix');

// require('laravel-mix-polyfill');

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

mix
    .js('resources/js/app.js', 'public/assets/js')
    .react()
    .sass('resources/sass/app.scss', 'public/assets/css')
    .options({
        postCss: [
            require("css-mqpacker")
        ]
    })
;

if (mix.inProduction()) {
    mix.version();
}
