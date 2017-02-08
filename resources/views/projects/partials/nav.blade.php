<ul class="nav nav-tabs nav-secondary">
  <li role="presentation" class="{{ strpos(Route::currentRouteName(), 'projects.show') === 0 ? 'active' : '' }}"><a href='{{ route("projects.show", $project->slug) }}'>Tracks</a></li>
  <li role="presentation" class="{{ strpos(Route::currentRouteName(), 'projects.tags') === 0 ? 'active' : '' }}"><a href='{{ route("projects.tags", $project->slug) }}'>Tags</a></li>
  <li role="presentation" class="{{ strpos(Route::currentRouteName(), 'projects.needs') === 0 ? 'active' : '' }}"><a href='{{ route("projects.needs", $project->slug) }}'>Needs</a></li>
  <li role="presentation" class="{{ strpos(Route::currentRouteName(), 'projects.settings') === 0 ? 'active' : '' }}"><a href='{{ route("projects.settings.edit", $project->slug) }}'>Settings</a></li>
</ul>
