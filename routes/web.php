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
Route::model('taxonomies', 'Taxonomy');
Route::model('needs', 'Need');

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
	Route::post('projects/{project}/tracks/upload', ['as' => 'tracks.upload', 'uses' => 'TrackController@upload']);

	Route::delete('tracks/{track}', ['as' => 'tracks.destroy', 'uses' => 'TrackController@destroy']);
	Route::delete('projects/{project}/tracks/{track}', ['as' => 'projects.tracks.destroy', 'uses' => 'TrackController@removeFromProject']);

	// Tags
	//Route::get('tags', ['as' => 'tags.index', 'uses' => 'TagController@index']);
	Route::get('tags/new', ['as' => 'tags.create', 'uses' => 'TagController@create']);
	Route::post('tags', ['as' => 'tags.store', 'uses' => 'TagController@store']);
	Route::delete('tags/{tag}', ['as' => 'tags.destroy', 'uses' => 'TagController@destroy']);
	Route::get('tags/search/autocomplete', ['as' => 'tags.autocomplete', 'uses' => 'TagController@autocomplete']);
	Route::post('tags/attach', ['as' => 'tags.attach', 'uses' => 'TagController@attach']);
	Route::post('tags/detach', ['as' => 'tags.detach', 'uses' => 'TagController@detach']);
	Route::get('projects/{project}/tags', ['as' => 'projects.tags', 'uses' => 'ProjectController@getTags']);

	// Taxonomies
	Route::get('taxonomies', ['as' => 'taxonomies.index', 'uses' => 'TaxonomyController@index']);
	Route::get('taxonomies/{taxonomy}', ['as' => 'taxonomies.show', 'uses' => 'TaxonomyController@show']);
	Route::get('taxonomies/add', ['as' => 'taxonomies.create', 'uses' => 'TaxonomyController@create']);
	Route::post('taxonomies', ['as' => 'taxonomies.store', 'uses' => 'TaxonomyController@store']);
	Route::get('taxonomies/{taxonomy}/tags', ['as' => 'taxonomies.tags.index', 'uses' => 'TagController@index']);
	Route::post('taxonomies/{taxonomy}/tags', ['as' => 'taxonomies.tags.store', 'uses' => 'TagController@store']);

	// Project Needs
	Route::resource('needs', 'NeedController');
	Route::get('needs/search/autocomplete', ['as' => 'needs.autocomplete', 'uses' => 'NeedController@autocomplete']);
	Route::post('needs/attach', ['as' => 'needs.attach', 'uses' => 'NeedController@attach']);
	Route::post('needs/detach', ['as' => 'needs.detach', 'uses' => 'NeedController@detach']);
	Route::get('projects/{project}/needs', ['as' => 'projects.needs', 'uses' => 'NeedController@get']);


});

Auth::routes();
