<div class="sidebar" id="sidebar">
    <div class="wrapper-button">
        <a class="navbar-brand btn-nav-toggle" href="#" title="Toggle Navigation"><i class="fa fa-bars"></i></a>
    </div>
    @hasSection('sidebar')
        @yield('sidebar', 'Sidebar')
    @else
        <div class="btn-group-vertical sidenav" role="group" aria-label="Main navigation">
            <a href="{{ route('projects.my') }}" class="btn btn-brand {{ strpos(Route::currentRouteName(), 'projects') === 0 ? 'active' : '' }}">Projects</a>
            <a href="{{ route('tracks.index') }}" class="btn btn-brand {{ strpos(Route::currentRouteName(), 'tracks') === 0 ? 'active' : '' }}">Tracks</a>
            <a href="{{ route('taxonomies.index') }}" class="btn btn-brand {{ strpos(Route::currentRouteName(), 'taxonomies') === 0 ? 'active' : '' }}">Taxonomies</a>
        </div>
    @endif
</div>
