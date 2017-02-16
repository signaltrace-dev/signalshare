<div class="track-item row" data-src='/files/{{ !empty($track->file) ? $track->file->filename : '' }}'>
    <div class="columns">
        <div class="column is-1 col-controls">
            <a href="{{ route('people.show', ['user' => $track->owner]) }}">
                @if (!empty($track->owner->profile->image_url))
                    <figure class="image is-32x32">
                        <img class="is-rounded" src="{{ $track->owner->profile->image_url }}" alt="" />
                    </figure>
                @else
                    <span class="icon user-badge">
                        <i class="fa fa-user-circle"></i>
                    </span>
                @endif
                <small>{{ '@' . $track->owner->name }}</small>
            </a>
            <br>
            <span class='controls-inline'>
              <button class='button is-warning is-small btn-mute'>Mute&nbsp;<i class='fa fa-volume-off'></i></button>
              @if ($user->id == $project->owner->id || $user->id == $track->owner->id)
                  <form action='{{ route("projects.tracks.destroy", [$project->slug, $track->slug] ) }}' method="POST">
                      {{ method_field('DELETE') }}
                      {{ csrf_field() }}
                      <button type="submit" class="button is-small is-danger">Remove</button>
                  </form>
              @endif
            </span>
        </div>
        <div class="column is-11 col-track">
            <h2 class="subtitle">{{ $track->name }}</h2>
            <div class='project-track'></div>
        </div>
    </div>
</div>
