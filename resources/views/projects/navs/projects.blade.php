<li role="presentation" class="{{ strpos(Route::currentRouteName(), 'projects.user') === 0 && $owned_by_current_user ? 'is-active' : '' }}"><a href='{{ route("projects.user", ["user" => $user]) }}'>My Projects</a></li>
<li role="presentation" class="{{ strpos(Route::currentRouteName(), 'projects.index') === 0 ? 'is-active' : '' }}"><a href='{{ route("projects.index") }}'>All Projects</a></li>
