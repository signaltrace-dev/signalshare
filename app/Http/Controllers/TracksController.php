<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Project;
use App\Track;
use App\AudioFile;
use Input;
use Redirect;
use Validator;
use App\Http\helpers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;



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
    public function create(Project $project, $ajax = NULL)
    {
      if($ajax === 'ajax')
      {
          return view('tracks.create_modal', compact('project'));
      }
      else return view('tracks.create', compact('project'));
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

    public function store(Project $project, Request $request)
    {

      $rules = array(
        'name'  => 'required',
      );



      $this->validate($request, $rules);
        $track = new Track;
        $track->project_id = $project->id;
        $track->name = Input::get('name');
        $track->owner_id = 1;
        $track->slug = Helpers::getSlug($track->name, $track);
        $track->save();

        //$file = Input::file('audio');
        $filename = Input::get('audiofile');
        $file = Storage::disk('local')->get($filename);

        $temp_file = $file->getRealPath();
        $hash = hash_file('md5', $temp_file);

        $filename = $project->id . '_' . $hash . '.' . $file->getClientOriginalExtension();
        if($file->move(base_path() . '/public/', $filename)){
          $file_obj = new AudioFile;
          $file_obj->filename = $filename;
          $file_obj->hash = $hash;
          $file_obj->track_id = $track->id;
          $file_obj->save();
        }

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
      $track->file->delete();
    	$track->delete();

    	return Redirect::route('projects.show', $project->slug)->with('message', 'Track deleted.');
    }

}
