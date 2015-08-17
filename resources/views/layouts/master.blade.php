<html>
    <head>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css">
      <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="{{ URL::asset('css/signalshare.css') }}">


      <meta name="csrf-token" content="{{ csrf_token() }}" />
      <script type='text/javascript'>
      $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
