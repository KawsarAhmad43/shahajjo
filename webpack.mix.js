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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/login_app.js', 'public/js')
    .js('resources/js/web_app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css')
    .options({ processCssUrls: false });


// ADMIN THEME CSS FILES MIX
mix.styles([
    'resources/js/assets/admin/css/bootstrap.min.css',
    'resources/js/assets/admin/css/smooth-scrollbar.css',
    'resources/js/assets/admin/css/main.css',
    'resources/js/assets/admin/css/fix.css',
    'resources/js/assets/admin/css/responsive.css',
], 'public/css/admin_layouts.css');

// ADMIN THEME JS FILES MIX
mix.scripts([
    'resources/js/assets/admin/js/jquery-1.12.4.min.js',
    'resources/js/assets/admin/js/bootstrap.bundle.min.js',
    'resources/js/assets/admin/js/waypoints.min.js',
    'resources/js/assets/admin/js/jquery.counterup.min.js',
    'resources/js/assets/admin/js/smooth-scrollbar.js',
    'resources/js/assets/admin/js/script.js',
], 'public/js/admin_layouts.js');


// COPY FILES / DIRECTORY
mix.copyDirectory('resources/js/assets/public', 'public')
    .copyDirectory('resources/js/assets/images', 'public/images')
    .copyDirectory('resources/js/assets/admin/css', 'public/assets/css')
    .copyDirectory('resources/js/assets/admin/js', 'public/assets/js');

// FOR CHANK
let config = {
    output: {
        publicPath: (process.env.MIX_VUE_ROUTER_BASE) ? '/' + process.env.MIX_VUE_ROUTER_BASE + '/public/' : '/',
        chunkFilename: 'js/chunks/[name].js',
    },
    stats: {
        children: true,
    },
};
mix.webpackConfig(config);
