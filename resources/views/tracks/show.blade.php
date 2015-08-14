@extends('layouts.master')

@section('content')
    <h2>
        {!! link_to_route('projects.show', $project->name, [$project->slug]) !!} -
        {{ $track->name }}
    </h2>

@endsection
