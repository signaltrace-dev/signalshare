<div class="track-item row" data-src='/files/{{ !empty($track->file) ? $track->file->filename : '' }}'>
    <div class="col col-md-1 col-controls">
        <span class='controls-inline'>
          <button class='btn btn-info btn-mute'>Mute <i class='fa fa-volume-off'></i></button>
          <form action='{{ route("projects.tracks.destroy", [$project->slug, $track->slug] ) }}' method="POST">
              {{ method_field('DELETE') }}
              {{ csrf_field() }}
              <button type="submit" class="btn btn-danger">Remove</button>
          </form>
        </span>
    </div>
    <div class="col-md-11 col-track">
        <a class='track-title'>{{ $track->name }}</a>
        <div class='project-track'></div>
    </div>
</div>
