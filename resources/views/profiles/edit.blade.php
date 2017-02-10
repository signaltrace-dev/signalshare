@extends('layouts/app')

@section('title')
    {{ $profile->title() }}
@endsection

@section('content')
    <form action='{{ route("profile.update", $profile->id) }}' method="POST" enctype="multipart/form-data" class="form-horizontal">
        {{ method_field('PATCH') }}
        {{ csrf_field() }}
        <div class="form-group">
            <label for="email" class="control-label col-sm-3">Email:</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="email"  placeholder="John" value="{{ !empty($profile->user->email) ? $profile->user->email : '' }}" />
            </div>
        </div>
        <div class="form-group">
            <label for="first_name" class="control-label col-sm-3">First Name:</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="first_name"  placeholder="John" value="{{ !empty($profile) ? $profile->first_name : '' }}" />
            </div>
        </div>
        <div class="form-group">
            <label for="last_name" class="control-label col-sm-3">Last Name:</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="last_name"  placeholder="Doe" value="{{ !empty($profile) ? $profile->last_name : '' }}" />
            </div>
        </div>
        <div class="form-group">
            <label for="city" class="control-label col-sm-3">City:</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="city"  placeholder="New York" value="{{ !empty($profile) ? $profile->city : '' }}" />
            </div>
        </div>
        <div class="form-group">
            <label for="country" class="control-label col-sm-3">Country:</label>
            <div class="col-sm-4">
                <input class="form-control" type="text" name="country"  placeholder="United States" value="{{ !empty($profile) ? $profile->country : '' }}" />
            </div>
        </div>
        <div class="form-group">
            <label for="bio" class="control-label col-sm-3">Bio:</label>
            <div class="col-sm-6">
                <textarea class="form-control" name="bio" placeholder="Awesome origin story here">{{ !empty($profile) ? $profile->bio : '' }}</textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="profile_image" class="control-label col-sm-3">Profile Image:</label>
            <div class="col-sm-4">
                @if (!empty($profile->image_url))
                    <img src="{{ $profile->image_url }}" />
                @endif
                <input class="form-control" type="file" name="profile_image" accept="image/*" />
            </div>
        </div>
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-4">
              <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </div>
    </form>

@endsection
