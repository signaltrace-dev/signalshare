@extends('layouts.app')

@section('title')
    {{ $project->name }} - Tags
@endsection

@section('pagenav')
    @include('projects.partials.nav', ['project' => $project])
@endsection

@section('content')
    <script type="text/javascript" src="{{ URL::asset('js/tags.js') }}"></script>

    <div id="tagger">
        @include('taxonomies.tags.forms.tag_picker', ['project' => $project])
    </div>

@endsection
