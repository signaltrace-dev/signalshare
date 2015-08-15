<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Project;
use Input;
use Redirect;
use App\Http\helpers;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
      $projects = Project::all();
		  return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit(Project $project)
    {
      return view('projects.edit', compact('project'));
    }

    public function store()
    {
      $project = new Project;
      $project->name = Input::get('name');
      $project->slug = Helpers::getSlug($project->name, $project);
      $project->owner_id = 1;
    	$project->save();

    	return Redirect::route('projects.index')->with('message', 'Project created');
    }

    public function update(Project $project)
    {
    	$input = array_except(Input::all(), '_method');
    	$project->update($input);

    	return Redirect::route('projects.show', $project->slug)->with('message', 'Project updated.');
    }

    public function destroy(Project $project)
    {
    	$project->delete();

    	return Redirect::route('projects.index')->with('message', 'Project deleted.');
    }
}
