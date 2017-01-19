@extends('layouts/app')

@section('content')
    <h2>Edit Project</h2>
    @include('projects/forms/create_edit', ['submit_text' => 'Save', 'form_action' => route("projects.update", $project->slug), 'form_method' => 'PATCH'])
@endsection
