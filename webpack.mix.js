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
    .react('resources/js/app.js', 'public/assets/js')
    .sass('resources/sass/app.scss', 'public/assets/css')
    .options({
        postCss: [
            require('autoprefixer')({
                browsers: ['last 2 versions'],
                grid: true
            }),
            require("css-mqpacker")
        ]
    })
;

mix.browserSync({
    files: [
        "resources/views/**/*.blade.php",
        "public/**/*.*"
    ],
    proxy: {
        target: "http://127.0.0.1:8000",
    }
});

if (mix.inProduction()) {
    mix.version();
}
