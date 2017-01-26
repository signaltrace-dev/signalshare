<div class="col-md-2 sidebar">
    <div class="pnl-badge">
        <a href="{{ action('DashboardController@index') }}"><img class="img-responsive" src="{{ URL::asset('img/st-badge.png') }}"/></a>
    </div>
    @hasSection('sidebar')
        @yield('sidebar', 'Sidebar')
    @else
        <ul class="list-group">
            @if (Auth::check())
                <li class="list-group-item"><a href="{{ route('projects.index') }}" class="{{ strpos(Route::currentRouteName(), 'projects') === 0 ? 'active' : '' }}">Projects</a></li>
                <li class="list-group-item"><a href="{{ route('tracks.index') }}" class="{{ strpos(Route::currentRouteName(), 'tracks') === 0 ? 'active' : '' }}">Tracks</a></li>
                <li class="list-group-item"><a href="{{ route('taxonomies.index') }}" class="{{ strpos(Route::currentRouteName(), 'taxonomies') === 0 ? 'active' : '' }}">Taxonomies</a></li>

                <li class="list-group-item">@include('partials/_logout')</li>


            @else
                <li class="list-group-item"><a href="{{ url('/login') }}">Login</a></li>
                <li class="list-group-item"><a href="{{ url('/register') }}">Register</a></li>
            @endif

        </ul>
    @endif
</div>
