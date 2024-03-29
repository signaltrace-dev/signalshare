<html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Aldrich" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <script type="text/javascript" src="{{ URL::asset('js/app.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/signalshare.js') }}"></script>

        <title>signal.share() @hasSection('title') - @yield('title')@endif</title>

        <script type="text/javascript">
            $(document).ready(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });
        </script>
    </head>
    <body class="{{$classes}}">
        @include('layouts.navbar')
        @include('layouts.sidebar')

        <div class="main-content container">
            @if (Session::has('message'))
                <div class="flash notification is-primary">
                  <p>{{ Session::get('message') }}</p>
                </div>
            @endif
            <div class='flash notification is-danger {{ $errors->any() ? '' : 'hidden' }}'>
                @foreach ( $errors->all() as $error )
                    <p>{{ $error }}</p>
                @endforeach
            </div>
            @hasSection('pagenav')
                <div class="columns">
                    <div class="column">
                        <div class="tabs is-boxed is-centered">
                            <ul class="nav-secondary">
                                @yield('pagenav')
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="has-nav">
            @else
                <div class="">
            @endif
                @yield('content')
            </div>
        </div>
    </body>
    <footer>
        @yield('footer')
    </footer>
</html>
