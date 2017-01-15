<html>
    <head>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
      <script type="text/javascript" src="{{ URL::asset('js/signalshare.js') }}"></script>
      <title>signal.share() - @yield('title')</title>
    </head>
    <body>
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
