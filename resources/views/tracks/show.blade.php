<div class="track-item row" data-src='/files/{{ !empty($track->file) ? $track->file->filename : '' }}'>
    <div class="columns">
        <div class="column is-1 col-controls">
            <span class='controls-inline'>
              <button class='button is-warning btn-mute'>Mute <i class='fa fa-volume-off'></i></button>
              <form action='{{ route("projects.tracks.destroy", [$project->slug, $track->slug] ) }}' method="POST">
                  {{ method_field('DELETE') }}
                  {{ csrf_field() }}
                  <button type="submit" class="button is-danger">Remove</button>
              </form>
            </span>
        </div>
        <div class="column is-11 col-track">
            <h2 class="subtitle">{{ $track->name }}</h2>
            <div class='project-track'></div>
        </div>
    </div>
</div>
