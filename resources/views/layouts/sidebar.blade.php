<div class="sidebar" id="sidebar">
    <div class="btn-nav-toggle-wrapper">
        <a class="btn-nav-toggle" href="#" title="Toggle Navigation"><i class="fa fa-bars"></i></a>
    </div>

    @hasSection('sidebar')
        @yield('sidebar', 'Sidebar')
    @else
        <aside class="menu">
          <p class="menu-label">
            Projects
          </p>
          <ul class="menu-list">
            <li>
                <a href="{{ route('projects.user', ['user' => $user]) }}" class="{{ strpos(Route::currentRouteName(), 'projects') === 0 ? 'is-active' : '' }}">Projects</a>
            </li>
          </ul>
          <p class="menu-label">
            Tracks
          </p>
          <ul class="menu-list">
              <li>
                  <a href="{{ route('tracks.index') }}" class="{{ strpos(Route::currentRouteName(), 'tracks') === 0 ? 'is-active' : '' }}">Tracks</a>
              </li>
          </ul>
          <p class="menu-label">
            People
          </p>
          <ul class="menu-list">
              <li>
                  <a href="{{ route('taxonomies.index') }}" class="{{ strpos(Route::currentRouteName(), 'taxonomies') === 0 ? 'is-active' : '' }}">Taxonomies</a>
              </li>
          </ul>
        </aside>
    @endif
</div>
