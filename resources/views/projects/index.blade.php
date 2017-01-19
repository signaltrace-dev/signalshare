@extends('layouts.app')

@section('title')
    Projects
@endsection

@section('content')
    <div class="panel panel-brand">
      <div class="panel-heading">
        <h3 class="panel-title">All Projects</h3>
      </div>
      <div class="panel-body">
          @if ( !$projects->count() )
              <div class='alert alert-warning'>
                There aren't any projects...yet.
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
      </div>
    </div>

    @include('projects/forms/create_edit', ['submit_text' => 'Create Project', 'project' => '', 'form_action' => route("projects.store"), 'form_method' => 'POST'])
@endsection
