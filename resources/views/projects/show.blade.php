@extends('layouts.app')

@section('title')
    {{ $project->name }}
@endsection

@section('navbar-middle')
    @include('projects.player')
@endsection

@section('pagenav')
    @include('projects.partials.nav', ['project' => $project])
@endsection

@section('content')

    <script type="text/javascript" src="{{ URL::asset('js/tracks.js') }}"></script>
    <script type="text/javascript">
        signalsharePlayer.project = "{{ $project->slug }}";
    </script>

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
    </div>
@endsection
