<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Project;
use App\Track;
use App\AudioFile;
use Redirect;
use Response;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class TrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Project $project)
    {
        return view('dashboards.tracks.index', compact('project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(Project $project, $ajax = NULL)
    {
      $track = new Track();
      if($ajax === 'ajax')
      {
          return view('tracks.create_modal', compact(['project', 'track']));
      }
      else return view('tracks.create', compact(['project', 'track']));
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

    public function showAjax($id){
        $track = Track::where('id', $id);

        return view('tracks.show', compact('track'));
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

    public function store(Request $request, Project $project)
    {
        $rules = array(
            'file' => 'required',
        );

        $response = array(
            'status' => 0,
        );

        $file_path = base_path() . '/storage/app/public/';
        $timestamp = time();

        if($request->hasFile('file')){
            $file = $request->file;
            $file_name = $file->getClientOriginalName();
            $file_ext = $file->getClientOriginalExtension();
            $file_name_arr = explode('.', $file_name);
            $file_name_short = !empty($file_name_arr[0]) ? $file_name_arr[0] : $file_name;

            $hash = hash_file('MD5', $file->getRealPath());
            $new_filename = $timestamp . '_' . $hash . '.' . $file_ext;

            $request->file->move($file_path, $new_filename);

            $track = new Track;
            $track->name = $file_name_short;
            $track->owner_id = $request->user()->id;

            $slug = str_slug($track->name, '-');
            $new_slug = $slug;

            $exists = Track::where(['slug' => $slug])->count();
            $append = 1;
            while($exists){
                $new_slug = $slug . '-' . $append;
                $append++;
                $exists = Track::where(['slug' => $new_slug])->count();
            }

            $track->slug = $new_slug;

            $track->save();

            $file_obj = new AudioFile;
            $file_obj->filename = $new_filename;
            $file_obj->hash = $hash;
            $file_obj->track_id = $track->id;
            $file_obj->save();

            $project->tracks()->attach($track->id,[
                'name' => $file_name_short,
                'owner_id' => $request->user()->id,
                'approved' => 0
            ]);

            $response['status'] = 1;
            $response['track'] = $track;
            $response['file'] = $file_obj;
            $response['project'] = $project;
        }

        if($request->ajax()){
            return Response::json($response);
        }

      	return Redirect::route('projects.show', $project->slug)->with('message', 'Added new track "' . $track->name . '"!');
    }

    public function update(Project $project, Track $track)
    {
    	$input = array_except(Input::all(), '_method');
    	$track->update($input);

    	return Redirect::route('projects.tracks.show', [$project->slug, $track->slug])->with('message', 'Track updated.');
    }

    public function removeFromProject(Project $project, Track $track)
    {
        $project->tracks()->detach($track->id);

        // Remove track / file entirely if it's not being used in any other projects
        $other_projects = $track->projects()->count();
        if($other_projects == 0){
            $track->delete();
        }

    	return Redirect::route('projects.show', $project->slug)->with('message', 'Removed "' . $track->name . '" from project.');
    }

    public function destroy(Track $track)
    {
    	$track->delete();

    	return Redirect::route('projects.show', $project->slug)->with('message', 'Track deleted.');
    }

}
