@extends('layouts.app')

@section('title')
    @if ($owned_by_current_user)
        My Projects
    @else
        {{ $project_user->name }}'s Projects
    @endif
@endsection

@section('pagenav')
    @include('projects.navs.projects')
@endsection

@section('content')
    <div class="columns">
        <div class="column is-8 is-offset-2">
            @if ( !$projects->count() )

              <div class='notification is-info'>
                  @if ($owned_by_current_user)
                      Hey {{$user->profile->first_name}}, it looks like you don't have any projects yet. Hop to it!
                  @else
                      It looks like {{ $project_user->name }} hasn't created any projects yet. Lame.
                  @endif
              </div>
            @else
                @foreach( $projects as $project )
                    @include('projects.teaser-single', ['project' => $project])
                @endforeach
            @endif
        </div>
    </div>

    @if($owned_by_current_user)
        <div class="columns">
            <div class="column is-half is-offset-one-quarter">
                @include('projects/forms/create_edit', ['submit_text' => 'Create Project', 'project' => '', 'form_action' => route("projects.store"), 'form_method' => 'POST'])
            </div>
        </div>

    @endif
@endsection
