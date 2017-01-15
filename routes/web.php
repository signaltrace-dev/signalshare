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
Route::model('files', 'AudioFile');

Route::group(['middleware' => 'auth'], function(){
	Route::get('/', 'DashboardController@index');

	Route::get('projects/{project}/tracks/create/{ajax?}', ['as' => 'create_track_ajax', 'uses' => 'TracksController@create']);
	Route::post('files/add', ['as' => 'create_file', 'uses' => 'AudioFilesController@storeTemp']);
	Route::post('files/delete', ['as' => 'delete_file', 'uses' => 'AudioFilesController@deleteTemp']);

	Route::resource('projects', 'ProjectController');
	Route::resource('projects.tracks', 'TrackController');
	Route::resource('files', 'AudioFilesController');

	Route::get('tracks', ['as' => 'tracks.index', 'uses' => 'TrackController@index']);
	Route::delete('tracks/{track}', ['as' => 'tracks.destroy', 'uses' => 'TrackController@destroy']);
	Route::delete('projects/{project}/tracks/{track}', ['as' => 'projects.tracks.destroy', 'uses' => 'TrackController@removeFromProject']);
});

Auth::routes();
