@extends('layouts.app')

@section('title')
    {{ $project->name }} - Needs
@endsection

@section('content')
    <script type="text/javascript" src="{{ URL::asset('js/tags.js') }}"></script>

    @include('projects.partials.nav', ['project' => $project])

    <div id="tagger">
        @include('needs.forms.need_tagger', ['project' => $project])
    </div>

@endsection
