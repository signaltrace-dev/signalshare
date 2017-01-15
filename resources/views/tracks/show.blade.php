<span class='controls-inline'>
  <span class='btn btn-info btn-play hidden'>Play <i class='fa fa-play'></i></span>
  <form action='{{ route("projects.tracks.destroy", [$project->slug, $track->slug] ) }}' method="POST">
      {{ method_field('DELETE') }}
      {{ csrf_field() }}
      <button type="submit" class="btn btn-danger">Remove</button>
  </form>
</span>
<a class='track-title'>{{ $track->name }}</a>

    <div class='project-track' data-src='/files/{{ !empty($track->file) ? $track->file->filename : '' }}'></div>
