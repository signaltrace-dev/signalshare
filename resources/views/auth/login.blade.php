@extends('layouts.app') @section('title') Login @endsection @section('content')
<div class="columns">
    <div class="column is-one-third is-offset-one-third">
        <div class="box">
            <form role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}
                <div class="control ">
                    <label class="label">Email</label>
                    <p class="control">
                        <input id="email" type="email" class="input is-fullwidth{{ $errors->has('email') ? ' is-danger' : '' }}" name="email" value="{{ old('email') }}" required autofocus> @if ($errors->has('email'))
                        <span class="help is-danger">
                            {{ $errors->first('email') }}
                        </span> @endif
                    </p>
                </div>
                <div class="control ">
                    <label class="label">Password</label>
                    <div class="control">
                        <input id="password" type="password" class="input{{ $errors->has('password') ? ' is-danger' : '' }}" name="password" required>
                    </div>
                    @if ($errors->has('password'))
                    <span class="help is-danger">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span> @endif
                </div>
                <p class="control ">
                    <label class="checkbox">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}}> Remember Me
                    </label>
                </p>
                <div class="control is-grouped">
                    <p class="control">
                        <button type="submit" class="button is-primary">Login</button>
                    </p>
                    <p class="control">
                        <a class="button is-link" href="{{ url('/password/reset') }}">
                            Forgot Your Password?
                        </a>
                    </p>
                    <p class="control">
                        <a class="button is-link" href="{{ url('/register') }}">Register</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
