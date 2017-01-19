<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\ProjectSettings;

class ProjectSettingsController extends Controller
{
    public function edit(Project $project, ProjectSettings $settings){
        return view('projects.settings.edit', compact('project', 'settings'));
    }


}
