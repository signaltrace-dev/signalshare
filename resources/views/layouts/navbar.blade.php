<nav class="nav">
    <div class="nav-left">
        @if (Auth::check())
            <a class="nav-item btn-nav-toggle" href="#" title="Toggle Navigation"><i class="fa fa-bars"></i></a>
        @endif
        <span class="nav-item title">@yield('title')</span>
    </div>
    <div class="nav-center">
        <a class="nav-item" href="/"><span class="icon"><i class="fa fa-home"></i></span></a>
        @yield('navbar-middle')
    </div>
    <div class="nav-right">
          @if (Auth::check())
              @if (!empty($user->profile))
                  <a href="{{ route('people.me') }}" class="nav-item">
                      @if (!empty($user->profile->image_url))
                          <img class="user-badge" src="{{ $user->profile->image_url }}"/>
                      @else
                          <span class="icon user-badge">
                              <i class="fa fa-user-circle"></i>
                          </span>
                      @endif
                      {{ $user->profile->title() }}
                  </a>
              @else
                  <a href="{{ route('people.me') }}" class="nav-item">
                      <span class="icon user-badge">
                          <i class="fa fa-user-circle"></i>
                      </span>
                      {{ $user->name }}
                  </a>
              @endif
              <a class="nav-item" href="{{ url('/logout') }}"
                  onclick="event.preventDefault();
                           document.getElementById('logout-form').submit();">
                  <i class="fa fa-sign-out"></i>&nbsp;Logout
              </a>

              <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
        @endif
    </div>
</nav>
