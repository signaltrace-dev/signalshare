@extends('layouts.app')

@section('title')
    {{ $project->name }} - Tags
@endsection

@section('content')
    <script type="text/javascript" src="{{ URL::asset('js/tags.js') }}"></script>

    @include('projects.partials.nav', ['project' => $project])

    <div id="tagger">
        @include('taxonomies.tags.forms.tag_picker', ['project' => $project])
    </div>

@endsection
