@extends('layouts/master')

@section('content')
    <h2>Edit Track "{{ $track->name }}"</h2>

    {!! Form::model($track, ['method' => 'PATCH', 'route' => ['projects.tracks.update', $project->slug, $track->slug]]) !!}
        @include('tracks/partials/_form', ['submit_text' => 'Edit Track'])
    {!! Form::close() !!}
@endsection
