<li role="presentation" class="{{ strpos(Route::currentRouteName(), 'projects.user') === 0 ? 'active' : '' }}"><a href='{{ route("projects.user", ["user" => $user]) }}'>My Projects</a></li>
<li role="presentation" class="{{ strpos(Route::currentRouteName(), 'projects.index') === 0 ? 'active' : '' }}"><a href='{{ route("projects.index") }}'>All Projects</a></li>
