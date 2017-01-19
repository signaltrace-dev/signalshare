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
Route::model('tags', 'Tag');

Route::group(['middleware' => 'auth'], function(){
	// Dashboards
	Route::get('/', 'DashboardController@index');

	// Projects
	Route::resource('projects', 'ProjectController');
	Route::get('projects/{project}/settings', ['as' => 'projects.settings.edit', 'uses' => 'ProjectSettingsController@edit']);
	Route::put('projects/{project}/settings', ['as' => 'projects.settings.update', 'uses' => 'ProjectSettingsController@update']);


	// Tracks
	Route::resource('projects.tracks', 'TrackController');
	Route::get('projects/{project}/tracks/create/{ajax?}', ['as' => 'create_track_ajax', 'uses' => 'TrackController@create']);
	Route::get('tracks', ['as' => 'tracks.index', 'uses' => 'TrackController@index']);
	Route::delete('tracks/{track}', ['as' => 'tracks.destroy', 'uses' => 'TrackController@destroy']);
	Route::delete('projects/{project}/tracks/{track}', ['as' => 'projects.tracks.destroy', 'uses' => 'TrackController@removeFromProject']);

	// Tags
	Route::get('tags', ['as' => 'tags.index', 'uses' => 'TagController@index']);
	Route::get('tags/new', ['as' => 'tags.create', 'uses' => 'TagController@create']);
	Route::post('tags', ['as' => 'tags.store', 'uses' => 'TagController@store']);
	Route::delete('tags/{track}', ['as' => 'tags.destroy', 'uses' => 'TagController@destroy']);

});

Auth::routes();
