@extends('layouts.app')

@section('title')
    All Projects
@endsection

@section('pagenav')
    @include('projects.navs.projects')
@endsection

@section('content')
    <div class="columns">
        <div class="column is-8 is-offset-2">
            @if ( !$projects->count() )
                <div class='notification is-info'>
                    There aren't any projects...yet.
                </div>
            @else
                @foreach( $projects as $project )
                    @include('projects.teaser-single', ['project' => $project])
                @endforeach
            @endif
        </div>
    </div>
    <div class="columns">
        <div class="column is-half is-offset-one-quarter">
            @include('projects/forms/create_edit', ['submit_text' => 'Create Project', 'project' => '', 'form_action' => route("projects.store"), 'form_method' => 'POST'])
        </div>
    </div>
@endsection
