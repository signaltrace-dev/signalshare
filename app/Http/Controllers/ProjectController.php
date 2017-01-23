<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use Redirect;
use App\Http\helpers;

class ProjectController extends Controller
{
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
      $project = new Project();
      return view('projects.create', compact('project'));
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show(Project $project){
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

  public function store(Request $request)
  {
      $this->validate($request, [
          'name' => 'required|unique:projects|max:255',
      ]);

    $project = new Project;
    $project->name = $request->input('name');

    $slug = str_slug($project->name, '-');
    $new_slug = $slug;

    $exists = Project::where(['slug' => $slug])->count();
    $append = 1;
    while($exists){
        $new_slug = $slug . '-' . $append;
        $append++;
        $exists = Project::where(['slug' => $new_slug])->count();
    }

    $project->slug = $new_slug;
    $project->owner_id = $request->user()->id;
    $project->save();

    return Redirect::route('projects.index')->with('message', 'Created new project ' . $project->name . '!');
  }

  public function update(Request $request, Project $project)
  {
    $input = array_except($request->all(), '_method');
    $input['slug'] = !empty($input['name']) ? str_slug($input['name']) : $project->slug;
    $project->update($input);

    return Redirect::route('projects.show', $project->slug)->with('message', 'Project updated.');
  }

  public function destroy(Request $request, Project $project)
  {
      $this->validate($request, [
          'project-name-confirm' => 'required|in:' . $project->fullPath(),
      ]);

    $project->delete();

    return Redirect::route('projects.index')->with('message', 'Deleted project ' . $project->name . '!');
  }

  public function getTags(Request $request, Project $project){
      if($request->ajax){
          $tags = $project->tags();
          return Response::json([
                'tags' => $tags,
          ]);

      }

      return view('tags.forms.tag_list', compact('project'));
  }
}
