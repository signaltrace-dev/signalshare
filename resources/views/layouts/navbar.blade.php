<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand btn-nav-toggle" href="#" title="Toggle Navigation"><i class="fa fa-bars"></i></a>
      <ul class="nav navbar-nav">
          <li class="page-title">@yield('title')</li>
      </ul>
    </div>
    <div class="navbar-middle">
        <ul class="nav navbar-nav">
            <li><a href="/"><i class="fa fa-home"></i></a></li>
        </ul>
        @yield('navbar-middle')
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
          @if (Auth::check())
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $user->name }} <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#">My Profile</a></li>
                <li role="separator" class="divider"></li>
                <li>@include('partials/_logout')</li>
              </ul>
            </li>
            @else
                <li><a href="{{ url('/login') }}">Login</a></li>
            @endif
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
