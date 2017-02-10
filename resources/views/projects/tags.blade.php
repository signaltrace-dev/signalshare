@extends('layouts.app')

@section('title')
    {{ $project->name }} - Tags
@endsection

@section('pagenav')
    @include('projects.navs.singleproject', ['project' => $project])
@endsection

@section('content')
    <script type="text/javascript" src="{{ URL::asset('js/tags.js') }}"></script>

    <div id="tagger">
        @include('taxonomies.tags.forms.tag_picker', ['project' => $project])
    </div>

@endsection
