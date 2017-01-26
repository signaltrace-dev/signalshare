const elixir = require('laravel-elixir');

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
