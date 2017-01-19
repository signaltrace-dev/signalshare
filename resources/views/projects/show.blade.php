@extends('layouts.app')

@section('title')
    {{ $project->name }}
    <a href='{{ route("projects.settings.edit", $project->slug) }}'><i class='fa fa-gear'></i></a>
@endsection

@section('content')

<script type="text/javascript" src="{{ URL::asset('js/tracks.js') }}"></script>
<div id="pnl-project-tracks">
    @if ( count($project->tracks) == 0 )
        <div class='alert alert-warning'>Hey, it looks like this project doesn't have any tracks yet. Get cracking!</div>
    @endif
    @include('tracks/forms/add_tracks', ['submit_text' => 'Create Track', 'project' => $project, 'action' => route("projects.tracks.store", $project->slug)])
    <div class='track-list' id="track-list">
        @foreach( $project->tracks as $track)
              @include('tracks/show', ['track' => $track, 'project' => $project])
        @endforeach
    </div>
    <div class="controls {{ count($project->tracks) == 0 ? 'hidden' : '' }}">
        <span class="btn btn-success btn-play-all"><span>Play All</span>&nbsp;<i class="fa fa-play"></i></span>
    </div>
</div>
@endsection
