@extends('layouts.app')

@section('title')
    {{ $profile->title() }}
@endsection

@section('pagenav')
    @if ($can_edit)
        @include('people.navs.single', ['profile' => $profile])
    @endif
@endsection

@section('content')
    <div class="columns">
        <div class="column is-half is-offset-one-quarter">
            <div class="card person">
              <div class="card-content">
                <div class="media">
                  <div class="media-left">
                      @if (!empty($profile->image_url))
                          <figure class="image user-badge" style="height: 90px; width: 90px;">
                            <img src="{{ $profile->image_url }}" alt="Image">
                          </figure>
                      @else
                          <div class="icon is-large">
                              <i class="fa fa-user-circle"></i>
                          </div>
                      @endif

                  </div>
                  <div class="media-content">
                    <p class="title is-4">{{ $profile->title() }}</p>
                    <p class="subtitle is-6">{{ '@' . $profile->user->name }}</p>

                    @if (!empty($profile->location()))
                        <p class="is-6">{{ $profile->location() }}</p>
                    @endif

                    <p class="is-6"><small>{{ RandomPersonDatePrefix() . ' since ' . $profile->user->created_at->format('F d, Y') }}</small></p>
                  </div>
                </div>
                @if (!empty($profile->bio))
                    <hr/>
                    <div class="content">
                        <p>{{ $profile->bio }}</p>
                    </div>
                @endif
                <hr/>
                <div class="panel">
                    <div class="panel-block">
                        @if ($profile->user->projects->count() > 0)
                            <a href="{{ route('projects.user', ['user' => $profile->user]) }}">{{ $profile->user->projects->count() }} Projects Owned</a>
                        @else
                            {{ $profile->user->projects->count() }} Projects Owned
                        @endif
                    </div>
                    <div class="panel-block">{{ $profile->user->collabs()->count() }} Collaborations</div>

                </div>
              </div>
          </div>
        </div>
    </div>

@endsection
