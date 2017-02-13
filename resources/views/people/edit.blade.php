@extends('layouts/app')

@section('title')
    {{ $profile->title() }}
@endsection

@section('pagenav')
    @include('people.navs.single', ['profile' => $profile])
@endsection

@section('content')
    <form action='{{ route("people.update", $profile->user->name) }}' method="POST" enctype="multipart/form-data" class="form-horizontal">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="control-label col-sm-3">Email:</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="email"  placeholder="somebody@signaltrace.net" value="{{ old('email', $profile->user->email) }}" />
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
            <label for="first_name" class="control-label col-sm-3">First Name:</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="first_name"  placeholder="John" value="{{ old('first_name', $profile->first_name) }}" />
                @if ($errors->has('first_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('first_name') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
            <label for="last_name" class="control-label col-sm-3">Last Name:</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="last_name"  placeholder="Doe" value="{{ old('last_name', $profile->last_name) }}" />
                @if ($errors->has('last_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('last_name') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
            <label for="username" class="col-sm-3 control-label">User Name</label>
            <div class="col-sm-4">
                <input id="username" type="text" class="form-control lower" name="username" value="{{ old('username', $profile->user->name) }}" placeholder="kingcrimson" required pattern="[a-zA-Z0-9-]{4,25}">
                @if ($errors->has('username'))
                    <span class="help-block">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
            <label for="city" class="control-label col-sm-3">City:</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="city"  placeholder="New York" value="{{ old('city', $profile->city) }}" />
                @if ($errors->has('city'))
                    <span class="help-block">
                        <strong>{{ $errors->first('city') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
            <label for="country" class="control-label col-sm-3">Country:</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="country"  placeholder="United States" value="{{ old('country', $profile->country) }}" />
                @if ($errors->has('country'))
                    <span class="help-block">
                        <strong>{{ $errors->first('country') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('bio') ? ' has-error' : '' }}">
            <label for="bio" class="control-label col-sm-3">Bio:</label>
            <div class="col-sm-6">
                <textarea class="form-control" name="bio" placeholder="Awesome origin story here">{{ old('bio', $profile->bio) }}</textarea>
                @if ($errors->has('bio'))
                    <span class="help-block">
                        <strong>{{ $errors->first('bio') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('profile_image') ? ' has-error' : '' }}">
            <label for="profile_image" class="control-label col-sm-3">Profile Image:</label>
            <div class="col-sm-4">
                @if (!empty($profile->image_url))
                    <img src="{{ $profile->image_url }}" />
                @endif
                <input class="form-control" type="file" name="profile_image" accept="image/*" />
                @if ($errors->has('profile_image'))
                    <span class="help-block">
                        <strong>{{ $errors->first('profile_image') }}</strong>
                    </span>
                @endif
            </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-4">
              <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
    </form>

@endsection
