<html>
    <head>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <title>signal.share() - @yield('title')</title>
    </head>
    <body>
        @section('sidebar')

        @show

        <div class="container">
          @if (Session::has('message'))
            <div class="flash alert-info">
              <p>{{ Session::get('message') }}</p>
            </div>
          @endif
            @yield('content')
        </div>
    </body>
</html>
