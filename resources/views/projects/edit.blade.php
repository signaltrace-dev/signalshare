@extends('layouts/app')

@section('content')
    <h2>Edit Project</h2>

    <form action='{{ route("projects.update", $project->slug) }}' method="POST">
        {{ method_field('PATCH') }}
        @include('projects/partials/_form', ['submit_text' => 'Save'])
    </form>
@endsection
