const elixir = require('laravel-elixir');

var rename = require('gulp-rename');
var path = require('path');
var glob = require('glob');
var sass = require('gulp-sass');
require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application as well as publishing vendor resources.
 |
 */

elixir((mix) => {
    mix.sass('app.scss')
       .webpack('app.js')
       .webpack('tags/tags.js')
       .scripts([
           'vendor/pluralize.js',
           'vendor/awesomplete.min.js',
           'ui/menu.js',
       ], 'public/js/signalshare.js')
       .scripts([
           'vendor/dropzone.js',
           'vendor/wavesurfer.min.js',
           'tracks/player.js',
           'tracks/uploader.js',
           'tracks/recorder.js',
           'tracks/metronome.js',
       ], 'public/js/tracks.js')
       .scripts([
           'tracks/metronomeworker.js',
       ], 'public/js/workers/metronomeworker.js');
});

// Build individual stylesheets for themes
var themes = glob.sync('resources/assets/sass/themes/*').map(function(themeDir) {
    return path.basename(themeDir);
});

themes.forEach(function(name) {
    elixir((mix) => {
        mix.sass('themes/' + name + '/theme.scss', 'public/css/themes/' + name + '.css');
    });
});
