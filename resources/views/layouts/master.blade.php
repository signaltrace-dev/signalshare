<html>
    <head>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="{{ URL::asset('css/signalshare.css') }}">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
      <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,500' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Merriweather:400,300,700' rel='stylesheet' type='text/css'>
      <script type="text/javascript" src="{{ URL::asset('js/signalshare.js') }}"></script>

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
            <div class='flash alert-danger {{ $errors->any() ? '' : 'hidden' }}'>
              @foreach ( $errors->all() as $error )
                <p>{{ $error }}</p>
              @endforeach
            </div>
            @yield('content')
        </div>
    </body>
</html>
