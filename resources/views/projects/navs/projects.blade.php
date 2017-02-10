<li role="presentation" class="{{ strpos(Route::currentRouteName(), 'projects.my') === 0 ? 'active' : '' }}"><a href='{{ route("projects.my") }}'>My Projects</a></li>
<li role="presentation" class="{{ strpos(Route::currentRouteName(), 'projects.index') === 0 ? 'active' : '' }}"><a href='{{ route("projects.index") }}'>All Projects</a></li>
