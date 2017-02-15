<li role="presentation" class="{{ strpos(Route::currentRouteName(), 'projects.show') === 0 ? 'is-active' : '' }}"><a href='{{ route("projects.show", ['username' => $project->owner->name, 'slug' => $project->slug]) }}'>Tracks</a></li>
<li role="presentation" class="{{ strpos(Route::currentRouteName(), 'projects.tags') === 0 ? 'is-active' : '' }}"><a href='{{ route("projects.tags", ['username' => $project->owner->name, 'slug' => $project->slug]) }}'>Tags</a></li>
<li role="presentation" class="{{ strpos(Route::currentRouteName(), 'projects.needs') === 0 ? 'is-active' : '' }}"><a href='{{ route("projects.needs", ['username' => $project->owner->name, 'slug' => $project->slug]) }}'>Needs</a></li>
<li role="presentation" class="{{ strpos(Route::currentRouteName(), 'projects.settings') === 0 ? 'is-active' : '' }}"><a href='{{ route("projects.settings.edit", ['username' => $project->owner->name, 'slug' => $project->slug]) }}'>Settings</a></li>
