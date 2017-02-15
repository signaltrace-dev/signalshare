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


}
