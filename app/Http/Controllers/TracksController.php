<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Track;
use Input;
use Redirect;

class TracksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Project $project)
    {
        return view('tracks.index', compact('project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Project $project)
    {
        return view('tracks.create', compact('project'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Project $project, Track $track)
    {
        return view('tracks.show', compact('project', 'track'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Project $project, Track $track)
    {
        return view('tracks.edit', compact('project', 'track'));
    }

    public function store(Project $project)
    {
    	$input = Input::all();
    	$input['project_id'] = $project->id;
    	Track::create( $input );

    	return Redirect::route('projects.show', $project->slug)->with('message', 'Track created.');
    }

    public function update(Project $project, Track $track)
    {
    	$input = array_except(Input::all(), '_method');
    	$track->update($input);

    	return Redirect::route('projects.tracks.show', [$project->slug, $track->slug])->with('message', 'Track updated.');
    }

    public function destroy(Project $project, Track $track)
    {
    	$track->delete();

    	return Redirect::route('projects.show', $project->slug)->with('message', 'Track deleted.');
    }

}
