<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::model('projects', 'Project');
Route::model('tracks', 'Track');

Route::group(['middleware' => 'auth'], function(){
	// Dashboards
	Route::get('/', 'DashboardController@index');

	// Projects
	Route::resource('projects', 'ProjectController');

	// Tracks
	Route::resource('projects.tracks', 'TrackController');
	Route::get('projects/{project}/tracks/create/{ajax?}', ['as' => 'create_track_ajax', 'uses' => 'TrackController@create']);
	Route::get('tracks', ['as' => 'tracks.index', 'uses' => 'TrackController@index']);
	Route::delete('tracks/{track}', ['as' => 'tracks.destroy', 'uses' => 'TrackController@destroy']);
	Route::delete('projects/{project}/tracks/{track}', ['as' => 'projects.tracks.destroy', 'uses' => 'TrackController@removeFromProject']);
});

Auth::routes();
