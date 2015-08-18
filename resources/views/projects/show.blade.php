@extends('layouts.master')

@section('content')

<div class="modal fade" id="modal">
  <div class="modal-dialog">
    <div class="modal-content">

    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript" src="{{ URL::asset('js/wavesurfer.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/signalshare.js') }}"></script>
<div id="pnl-project-tracks">
    <h2>{{ $project->name }}</h2>

    @if ( !$project->tracks->count() )
        <div class='alert alert-info'>Woah woah woah...looks like your project doesn't have any tracks yet. Get cracking!</div>
    @else
        <ul class='track-list'>
          @foreach( $project->tracks as $track )
              <li class='track-item'>
                {!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'route' => array('projects.tracks.destroy', $project->slug, $track->slug))) !!}
                  <span class='controls-inline'>
                    <span class='btn btn-info btn-play hidden'>Play <i class='fa fa-play'></i></span>
                    {!! Form::submit('Delete', array('class' => 'btn btn-danger btn-delete')) !!}
                  </span>
                  <a class='track-title' href="{{ route('projects.tracks.show', [$project->slug, $track->slug]) }}">{{ $track->name }}</a>
                  <div class='project-track' data-src='http://localhost/signalshare/public/{{ $track->file->filename }}'></div>
                {!! Form::close() !!}
              </li>
          @endforeach
        </ul>
    @endif
    <div class="controls">
      <span class="btn btn-info btn-play-all"><span>Play All</span>&nbsp;<i class="fa fa-play"></i></span>
      <a class='btn btn-warning' data-toggle="modal" href="{{ route('projects.tracks.create', [$project->slug]) }}" data-target="#modal">Add a Track</a>


    </div>
    <p>
        {!! link_to_route('projects.index', 'Back to Projects') !!} |
    </p>
</div>
@endsection
