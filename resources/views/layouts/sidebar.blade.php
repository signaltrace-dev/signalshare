<div class="sidebar" id="sidebar">
    <div class="wrapper-button">
        <a class="navbar-brand btn-nav-toggle" href="#" title="Toggle Navigation"><i class="fa fa-bars"></i></a>
    </div>
    @hasSection('sidebar')
        @yield('sidebar', 'Sidebar')
    @else
        <ul class="list-group">
            <li class="list-group-item"><a href="{{ route('projects.index') }}" class="{{ strpos(Route::currentRouteName(), 'projects') === 0 ? 'active' : '' }}">Projects</a></li>
            <li class="list-group-item"><a href="{{ route('tracks.index') }}" class="{{ strpos(Route::currentRouteName(), 'tracks') === 0 ? 'active' : '' }}">Tracks</a></li>
            <li class="list-group-item"><a href="{{ route('taxonomies.index') }}" class="{{ strpos(Route::currentRouteName(), 'taxonomies') === 0 ? 'active' : '' }}">Taxonomies</a></li>
        </ul>
    @endif
</div>
