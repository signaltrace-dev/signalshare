@extends('layouts.app')

@section('title')
    {{ $project->name }}
@endsection

@section('navbar-middle')
    @include('projects.player')
@endsection

@section('content')
    <a class="btn btn-default" href='{{ route("projects.settings.edit", $project->slug) }}'><i class='fa fa-gear'></i>&nbsp;Settings</a>

    @include('taxonomies.tags.partials.tag_list', ['project' => $project])

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
