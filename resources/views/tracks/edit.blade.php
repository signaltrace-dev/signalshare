@extends('layouts/app')

@section('content')
    <h2>Edit Track "{{ $track->name }}"</h2>

    <form class="dropzone" action='{{ route("projects.tracks.update", [$project->slug, $track->slug]) }}' method="POST">
        {{ method_field('PATCH') }}
        @include('tracks/partials/_form', ['submit_text' => 'Edit Track', 'action' => route("projects.tracks.update", $project->slug)])
      </form>
@endsection
