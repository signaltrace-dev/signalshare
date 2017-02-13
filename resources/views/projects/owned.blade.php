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
    @if ( !$projects->count() )
      <div class='alert alert-warning'>
          @if ($owned_by_current_user)
              Hey {{$user->profile->first_name}}, it looks like you don't have any projects yet. Hop to it!
          @else
              It looks like {{ $project_user->name }} hasn't created any projects yet. Lame.
          @endif
      </div>
    @else
      <div class="list-group project-list">
          @foreach( $projects as $project )
              <a class="list-group-item" href="{{ route('projects.show', ['user' => $project->owner->name, 'slug' => $project->slug]) }}">
                  {{ $project->name }}
                  @if ($project->totalTracks() > 0)
                      <span class="badge badge-success">{{ $project->totalTracks() }} {{ $project->totalTracks() > 1 ? 'tracks' : 'track' }} </span>
                  @else
                      <span class="badge badge-danger">0 tracks</span>
                  @endif
              </a>
          @endforeach
      </div>
    @endif

    @if($owned_by_current_user)
        @include('projects/forms/create_edit', ['submit_text' => 'Create Project', 'project' => '', 'form_action' => route("projects.store"), 'form_method' => 'POST'])
    @endif
@endsection
