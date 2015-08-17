@extends('layouts.master')

@section('content')
<script type="text/javascript" src="{{ URL::asset('js/wavesurfer.min.js') }}"></script>

<script type="text/javascript">
  $(document).ready(function(){
    var signalshare = {};
    signalshare.tracks = [];
    $('.project-track').each(function(){
      var trackElem = this;
        var src = $(this).data('src');
        var wavesurfer = Object.create(WaveSurfer);

        wavesurfer.init({
            container: trackElem,
            waveColor: 'blue',
            progressColor: 'purple'
        });

        wavesurfer.load(src);
        signalshare.tracks.push(wavesurfer);

      });
      $('.btn-play-all').on('click', function(){
        $(signalshare.tracks).each(function(){
          if(this.backend.source){
            this.play();
        }//this.play();
        });
      });

  });

</script>
<div id='wave'></div>
    <h2>{{ $project->name }}</h2>

    @if ( !$project->tracks->count() )
        Your project has no tracks.
    @else
        <ul>
          @foreach( $project->tracks as $track )
              <li>
                  {!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'route' => array('projects.tracks.destroy', $project->slug, $track->slug))) !!}
                      <div class='project-track' data-src='http://localhost/signalshare/public/{{ $track->file->filename }}'></div>
                      <a href="{{ route('projects.tracks.show', [$project->slug, $track->slug]) }}">{{ $track->name }}</a>
                          {!! link_to_route('projects.tracks.edit', 'Edit', array($project->slug, $track->slug), array('class' => 'btn btn-info')) !!}
                          {!! Form::submit('Delete', array('class' => 'btn btn-danger')) !!}
                  {!! Form::close() !!}
              </li>
          @endforeach
        </ul>
    @endif
    <div class="controls">
      <ul>
        <li><span class="btn btn-info btn-play-all">Play</span>
      </ul>
    </div>
    <p>
        {!! link_to_route('projects.index', 'Back to Projects') !!} |
        {!! link_to_route('projects.tracks.create', 'Create Track', $project->slug) !!}
    </p>
@endsection
