<span class='controls-inline'>
  <button class='btn btn-warning btn-mute'>Mute <i class='fa fa-volume-off'></i></button>
  <form action='{{ route("projects.tracks.destroy", [$project->slug, $track->slug] ) }}' method="POST">
      {{ method_field('DELETE') }}
      {{ csrf_field() }}
      <button type="submit" class="btn btn-danger">Remove</button>
  </form>
</span>
<a class='track-title'>{{ $track->name }}</a>

<div class='project-track' data-src='/files/{{ !empty($track->file) ? $track->file->filename : '' }}'></div>
