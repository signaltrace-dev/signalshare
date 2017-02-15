<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\ProjectSettings;
use App\User;

class ProjectSettingsController extends Controller
{
    public function edit(User $user, $slug, ProjectSettings $settings){
        $project = Project::where(['user_id' => $user->id, 'slug' => $slug])->get()->first();

        return view('projects.settings.edit', compact('project', 'settings'));
    }

    public function update(Request $request, User $user, $slug){
        $project = Project::where(['user_id' => $user->id, 'slug' => $slug])->get()->first();

        $project->name = !empty($request->input('name')) ? $request->input('name') : $project->name;
        $project->description = !empty($request->input('description')) ? $request->input('description') : $project->description;

        $project->save();

        return redirect()->back()->with('message', 'Updated project settings!');

    }


}
