@extends('layouts/app')

@section('title')
    {{ $project->name }} :: Add Tracks
@endsection
@section('content')
    @include('tracks/forms/add_tracks', ['submit_text' => 'Create Track', 'project' => $project, 'action' => route("projects.tracks.store", $project->slug)])
@endsection
