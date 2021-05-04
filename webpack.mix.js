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

const tailwindcss = require('tailwindcss');

mix.js('resources/js/admin/app.js', 'public/js/admin.js')
 .sass('resources/sass/admin/app.scss', 'public/css/admin.css')
 .options({
     processCssUrls: false,
     postCss: [tailwindcss('./tailwind.config.js')],
 });
 
// mix.js('resources/js/app.js', 'public/js')
//     .postCss('resources/css/app.css', 'public/css', [
//         require('postcss-import'),
//         require('tailwindcss'),
//     ]);

// mix.copyDirectory('~@fortawesome/fontawesome-free/webfonts', 'public/webfonts');

if (mix.inProduction()) {
    mix.version();
}
