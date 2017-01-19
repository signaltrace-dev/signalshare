@extends('layouts/app')

@section('content')
    <h2>Create Project</h2>
    @include('projects/forms/create_edit', ['submit_text' => 'Create Project', 'form_action' => route("projects.store"), 'form_method' => 'POST'])
@endsection
