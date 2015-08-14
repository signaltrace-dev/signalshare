@extends('layouts.master')

@section('content')
    <h2>{{ $project->name }}</h2>

    @if ( !$project->tracks->count() )
        Your project has no tracks.
    @else
        <ul>
            @foreach( $project->tracks as $track )
                <li><a href="{{ route('projects.tracks.show', [$project->slug, $track->slug]) }}">{{ $track->name }}</a></li>
            @endforeach
        </ul>
    @endif
@endsection
