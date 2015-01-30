var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.less('app.less')
        .scripts([
            'jquery/dist/jquery.js',
            'bootstrap/dist/js/bootstrap.js',
            'marked/lib/marked.js',
            'epiceditor/src/editor.js',
            'highlightjs/highlight.pack.js',
            'main.js'
        ], 'resources/assets/vendor')
        .copy('resources/assets/vendor/bootstrap/fonts', 'public/fonts')
        .copy('resources/assets/vendor/fontawesome/fonts', 'public/fonts')
        .copy('resources/assets/vendor/epiceditor/epiceditor/themes', 'public/epiceditor/themes')
        .copy('resources/assets/vendor/html5shiv/dist/html5shiv.js', 'public/js/html5shiv.js')
        .copy('resources/assets/vendor/respond/src/respond.js', 'public/js/respond.js')
        .version('css/app.css');
});
