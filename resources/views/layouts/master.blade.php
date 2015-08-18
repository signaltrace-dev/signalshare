<html>
    <head>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="{{ URL::asset('css/signalshare.css') }}">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
      <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,500' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>
      <link href='http://fonts.googleapis.com/css?family=Merriweather:400,300,700' rel='stylesheet' type='text/css'>


      <script type='text/javascript'>
      $.ajaxPrefilter(function(options, originalOptions, xhr) {
    var token = $('meta[name="csrf_token"]').attr('content');

    if (token) {
          return xhr.setRequestHeader('X-XSRF-TOKEN', token);
    }
});
      </script>
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
          @if ($errors->any())
            <div class='flash alert-danger'>
              @foreach ( $errors->all() as $error )
                <p>{{ $error }}</p>
              @endforeach
            </div>
          @endif
            @yield('content')
        </div>
    </body>
</html>
