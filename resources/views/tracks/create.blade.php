@extends('layouts/master')

@section('content')
    <h2>Create Track for Project "{{ $project->name }}"</h2>
    {!! Form::model(new App\Track, ['route' => ['projects.tracks.store', $project->slug], 'files'=>true]) !!}
        @include('tracks/partials/_form', ['submit_text' => 'Create Track', 'project' => $project])
    {!! Form::close() !!}
@endsection
