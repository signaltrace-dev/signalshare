<html>
    <head>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
      <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
      <title>signal.share() @hasSection('title') - @yield('title')@endif</title>
    </head>
    <body class="{{$classes}}">
        <div class="container-fluid">
            <div class="row">
                @include('layouts/sidebar')

                <div class="col-md-10">
                    <div class="title--page">
                        <h1>
                            @yield('title')
                        </h1>
                    </div>
                    @if (Session::has('message'))
                        <div class="flash alert alert-info">
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
            </div>
        </div>
    </body>
</html>
