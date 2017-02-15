@extends('layouts/app')

@section('title')
    {{ $profile->title() }}
@endsection

@section('pagenav')
    @include('people.navs.single', ['profile' => $profile])
@endsection

@section('content')
    <div class="columns">
        <div class="column is-half is-offset-one-quarter">
            <div class="card">
                <div class="card-content">

                    <form action='{{ route("people.update", $profile->user->name) }}' method="POST" enctype="multipart/form-data" class="form-horizontal">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}

                        <div class="control">
                            <label for="email" class="label">Email Address</label>
                            <p class="control">
                                <input id="email" type="text" class="input is-fullwidth" name="email" value="{{ old('email', $profile->user->email) }}" placeholder="somebody@signaltrace.net" required>
                                @if ($errors->has('email'))
                                    <span class="help is-danger">
                                        {{ $errors->first('email') }}
                                    </span>
                                @endif
                            </p>
                        </div>

                        <div class="control">
                            <label for="first_name" class="label">First Name</label>
                            <p class="control">
                                <input id="first_name" type="text" class="input is-fullwidth" name="first_name" value="{{ old('first_name', $profile->first_name) }}" placeholder="Robert" required autofocus>
                                @if ($errors->has('first_name'))
                                    <span class="help is-danger">
                                        {{ $errors->first('first_name') }}
                                    </span>
                                @endif
                            </p>
                        </div>

                        <div class="control">
                            <label for="last_name" class="label">Last Name</label>
                            <p class="control">
                                <input id="last_name" type="text" class="input is-fullwidth" name="last_name" value="{{ old('last_name', $profile->last_name) }}" placeholder="Fripp" required>
                                @if ($errors->has('last_name'))
                                    <span class="help is-danger">
                                        {{ $errors->first('last_name') }}
                                    </span>
                                @endif
                            </p>
                        </div>

                        <div class="control">
                            <label for="username" class="label">User Name</label>
                            <p class="control">
                                <input id="username" type="text" class="input is-fullwidth" name="username" value="{{ old('username', $profile->user->name) }}" placeholder="kingcrimson" required>
                                @if ($errors->has('username'))
                                    <span class="help is-danger">
                                        {{ $errors->first('username') }}
                                    </span>
                                @endif
                            </p>
                        </div>

                        <div class="control">
                            <label for="city" class="label">City</label>
                            <p class="control">
                                <input id="city" type="text" class="input is-fullwidth" name="city" value="{{ old('city', $profile->city) }}" placeholder="New York City">
                                @if ($errors->has('city'))
                                    <span class="help is-danger">
                                        {{ $errors->first('city') }}
                                    </span>
                                @endif
                            </p>
                        </div>

                        <div class="control">
                            <label for="country" class="label">Country</label>
                            <p class="control">
                                <select class="select is-fullwidth chosen-select" name="country" data-placeholder="Choose a country">
                                    <option></option>
                                    @foreach (CountryCodes() as $key => $value)
                                        <option {{ old('country', $profile->country) == $key ? 'selected' : '' }} value="{{$key}}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('country'))
                                    <span class="help is-danger">
                                        {{ $errors->first('country') }}
                                    </span>
                                @endif
                            </p>
                        </div>

                        <div class="control">
                            <label for="bio" class="label">Bio</label>
                            <p class="control">
                                <textarea id="bio" class="textarea is-fullwidth" name="bio" placeholder="Insert awesome origin story here">{{ old('bio', $profile->bio) }}</textarea>
                                @if ($errors->has('bio'))
                                    <span class="help is-danger">
                                        {{ $errors->first('bio') }}
                                    </span>
                                @endif
                            </p>
                        </div>

                        <div class="control">
                            <label for="profile_image" class="label">Profile Image:</label>

                            <p class="control">
                                @if (!empty($profile->image_url))
                                    <figure class="image is-96x96">
                                        <img src="{{ $profile->image_url }}" />
                                    </figure>

                                @endif
                                <input class="input" type="file" name="profile_image" accept="image/*" />
                                @if ($errors->has('profile_image'))
                                    <span class="help is-danger">
                                        {{ $errors->first('profile_image') }}
                                    </span>
                                @endif
                            </p>
                        </div>

                        <div class="control is-grouped">
                            <p class="control">
                                <button type="submit" class="button is-primary">Save</button>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
