@extends('layouts.app')

@section('title')
    Register
@endsection

@section('content')
    <div class="columns">
        <div class="column is-one-third is-offset-one-third">
            <div class="box user-form">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                    {{ csrf_field() }}
                    <div class="control ">
                        <label for="first_name" class="label">First Name</label>
                        <p class="control">
                            <input id="first_name" type="text" class="input is-fullwidth {{ $errors->has('first_name') ? 'is-danger' : '' }}" name="first_name" value="{{ old('first_name') }}" placeholder="Robert" required autofocus>
                            @if ($errors->has('first_name'))
                                <span class="help is-danger">
                                    {{ $errors->first('first_name') }}
                                </span>
                            @endif
                        </p>
                    </div>

                    <div class="control ">
                        <label for="last_name" class="label">Last Name</label>
                        <p class="control">
                            <input id="last_name" type="text" class="input is-fullwidth {{ $errors->has('last_name') ? 'is-danger' : '' }}" name="last_name" value="{{ old('last_name') }}" placeholder="Fripp" required>
                            @if ($errors->has('last_name'))
                                <span class="help is-danger">
                                    {{ $errors->first('last_name') }}
                                </span>
                            @endif
                        </p>
                    </div>

                    <div class="control ">
                        <label for="username" class="label">User Name</label>
                        <p class="control">
                            <input id="username" v-model="userName" type="text" v-bind:class="{ 'is-danger': !userNameValid }" class="input is-fullwidth {{ $errors->has('username') ? 'is-danger' : '' }}" name="username" value="{{ old('username') }}" placeholder="kingcrimson" required>
                            <span class="help is-danger" v-show="!userNameValid" v-cloak>
                                The username has already been taken.
                            </span>
                            @if ($errors->has('username'))
                                <span class="help is-danger">
                                    {{ $errors->first('username') }}
                                </span>
                            @endif
                        </p>
                    </div>

                    <div class="control ">
                        <label for="email" class="label">Email Address</label>
                        <p class="control">
                            <input id="email" type="text" class="input is-fullwidth {{ $errors->has('email') ? 'is-danger' : '' }}" name="email" value="{{ old('email') }}" placeholder="somebody@signaltrace.net" required>
                            @if ($errors->has('email'))
                                <span class="help is-danger">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </p>
                    </div>

                    <div class="control ">
                        <label for="password" class="label">Password</label>
                        <p class="control">
                            <input id="password" type="password" class="input is-fullwidth {{ $errors->has('password') ? 'is-danger' : '' }}" name="password" required>
                            @if ($errors->has('password'))
                                <span class="help is-danger">
                                    {{ $errors->first('password') }}
                                </span>
                            @endif
                        </p>
                    </div>

                    <div class="control ">
                        <label for="password-confirm" class="label">Confirm Password</label>
                        <p class="control">
                            <input id="password-confirm" type="password" class="input is-fullwidth {{ $errors->has('password_confirmation') ? 'is-danger' : '' }}" name="password_confirmation" required>
                            @if ($errors->has('password_confirmation'))
                                <span class="help is-danger">
                                    {{ $errors->first('password_confirmation') }}
                                </span>
                            @endif
                        </p>
                    </div>

                    <div class="control is-grouped">
                        <p class="control">
                            <button type="submit" class="button is-primary">Register</button>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
