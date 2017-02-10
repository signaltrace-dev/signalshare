@extends('layouts.app')

@section('title')
    My Projects
@endsection

@section('pagenav')
    @include('projects.navs.projects')
@endsection

@section('content')
    @if ( !$projects->count() )
      <div class='alert alert-warning'>
        Hey {{$user->profile->first_name}}, it looks like you don't have any projects yet. Hop to it!
      </div>
    @else
      <div class="list-group project-list">
          @foreach( $projects as $project )
              <a class="list-group-item" href="{{ route('projects.show', $project->slug) }}">
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

    @include('projects/forms/create_edit', ['submit_text' => 'Create Project', 'project' => '', 'form_action' => route("projects.store"), 'form_method' => 'POST'])
@endsection