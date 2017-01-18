@extends('layouts.app')

@section('content')

<script type="text/javascript" src="{{ URL::asset('js/tracks.js') }}"></script>
<div id="pnl-project-tracks">
    <h2>{{ $project->name }}</h2>

    @if ( count($project->tracks) == 0 )
        <div class='alert alert-warning'>Hey, it looks like this project doesn't have any tracks yet. Get cracking!</div>
    @endif
    @include('tracks/forms/add_tracks', ['submit_text' => 'Create Track', 'project' => $project, 'action' => route("projects.tracks.store", $project->slug)])
    <ul class='track-list' id="track-list">
      @foreach( $project->tracks as $track)
          <li class='track-item'>
              @include('tracks/show', ['track' => $track, 'project' => $project])
          </li>
      @endforeach
    </ul>
    <div class="controls {{ count($project->tracks) == 0 ? 'hidden' : '' }}">
        <span class="btn btn-info btn-play-all"><span>Play All</span>&nbsp;<i class="fa fa-play"></i></span>
    </div>
</div>
@endsection
