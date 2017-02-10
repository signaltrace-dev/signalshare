@extends('layouts.app')

@section('title')
    {{ $project->name }} - Needs
@endsection

@section('pagenav')
    @include('projects.partials.nav', ['project' => $project])
@endsection

@section('content')
    <script type="text/javascript" src="{{ URL::asset('js/tags.js') }}"></script>

    <div id="tagger">
        @include('needs.forms.need_tagger', ['project' => $project])
    </div>
@endsection
