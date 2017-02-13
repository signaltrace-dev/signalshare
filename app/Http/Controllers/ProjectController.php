<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Project;
use Redirect;
use Response;
use App\Http\helpers;
use App\User;
use Validator;

class ProjectController extends Controller
{
  public function index()
  {
    $projects = Project::all();
    return view('projects.index', compact('projects'));
  }

  public function my(Request $request)
  {
      $user = $request->user();

      return redirect()->route('projects.user', ['user' => $user]);
  }


  public function indexOwned(User $user)
  {
      $projects = Project::where('owner_id', $user->id)->get();
      return view('projects.owned', compact('projects', 'user'));
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
  public function show(User $user, $slug){
      $project = Project::where(['owner_id' => $user->id, 'slug' => $slug])->get()->first();
      if(!empty($project))
      {
          return view('projects.show', compact('project'));
      }

      abort(404);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit(User $user, $slug)
  {
      $project = Project::where(['owner_id' => $user->id, 'slug' => $slug])->get()->first();

      if(!empty($project)){
          return view('projects.edit', compact('project'));
      }

      abort(404);

  }

  public function store(Request $request)
  {
      $user = $request->user();

      $rules = [
          'name' => [
              'required',
              'max:255',
              Rule::unique('projects')->where(function ($query) use ($user) {
                  $query->where('owner_id', $user->id);
              })
          ]
      ];

      $messages = [
          'name.unique' => 'It looks like you already have a project named "' . $request->input('name') . '". Try something else!',
      ];
      $validator = Validator::make($request->all(), $rules, $messages);

      if($validator->fails()){
          return redirect()->back()->withErrors($validator)->withInput();
      }


    $project = new Project;
    $project->name = $request->input('name');

    $slug = str_slug($project->name, '-');
    $new_slug = $slug;

    $exists = Project::where(['slug' => $slug, 'owner_id' => $user->id])->count();
    $append = 1;
    while($exists){
        $new_slug = $slug . '-' . $append;
        $append++;
        $exists = Project::where(['slug' => $new_slug, 'owner_id' => $user->id])->count();
    }

    $project->slug = $new_slug;
    $project->owner_id = $user->id;
    $project->save();

    return redirect()->back()->with('message', 'Created new project ' . $project->name . '!');
  }

  public function destroy(Request $request, User $user, $slug)
  {
      $project = Project::where(['owner_id' => $user->id, 'slug' => $slug])->get()->first();

      if(!empty($project)){
          $this->validate($request, [
              'project-name-confirm' => 'required|in:' . $project->fullPath(),
          ]);

        $project->delete();

        return Redirect::route('projects.index')->with('message', 'Deleted project ' . $project->name . '!');
    }
    abort(404);

  }

  public function getTags(Request $request, User $user, $slug){
      $project = Project::where(['owner_id' => $user->id, 'slug' => $slug])->get()->first();

      if(!empty($project)){
          if($request->ajax()){
              $tags = $project->tags()->get();
              return Response::json($tags);

          }
          return view('projects.tags', compact('project'));
      }
      abort(404);
  }
}
