<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::model('projects', 'Project');
Route::model('tracks', 'Track');

Route::resource('projects', 'ProjectsController');
Route::resource('projects.tracks', 'TracksController');

Route::bind('tracks', function($value, $route) {
	return App\Track::whereSlug($value)->first();
});
Route::bind('projects', function($value, $route) {
	return App\Project::whereSlug($value)->first();
});
