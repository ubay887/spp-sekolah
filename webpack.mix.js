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
mix.setResourceRoot('../');
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

// mix.js('resources/js/jenisPembayaran.js', 'public/js');
mix.js('resources/js/pembayaran.js', 'public/js');
mix.js('resources/js/userPembayaran.js', 'public/js');
// mix.js('resources/js/pindahKelas.js', 'public/js');
