let mix = require('laravel-mix');



mix.scripts([
    'resources/assets/js/jquery.js',
    'resources/assets/js/bootstrap.js',
    'resources/assets/js/toastr.js',
    'resources/assets/js/vue.js',
    'resources/assets/js/axios.js',
    'resources/assets/js/app.js',
    ], 'public/js/app.js')
    .styles([
    'resources/assets/css/bootstrap.css',
    'resources/assets/css/toastr.css',
    'resources/assets/css/animate.css',   
    ], 'public/css/app.css');
