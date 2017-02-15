@extends('layouts.app')

@section('title')
    {{ $project->name }} - Needs
@endsection

@section('pagenav')
    @include('projects.navs.singleproject', ['project' => $project])
@endsection

@section('content')
    <div class="columns">
        <div class="column is-half is-offset-one-quarter">
            <script type="text/javascript" src="{{ URL::asset('js/tags.js') }}"></script>

            <div id="tagger">
                @include('needs.forms.need_tagger', ['project' => $project])
            </div>
        </div>
    </div>
@endsection
