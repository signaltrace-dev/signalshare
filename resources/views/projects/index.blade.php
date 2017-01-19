@extends('layouts.app')

@section('title')
    Projects
@endsection

@section('content')
  @if ( !$projects->count() )
    <div class='alert alert-info'>
      There aren't any projects...yet.
    </div>
  @else
  <div class="list-group project-list">
      @foreach( $projects as $project )
          <a class="list-group-item" href="{{ route('projects.show', $project->slug) }}">
              {{ $project->name }}
              @if ($project->totalTracks() > 0)
                  <span class="badge">{{ $project->totalTracks() }} {{ $project->totalTracks() > 1 ? 'tracks' : 'track' }} </span>
              @endif
          </a>
      @endforeach
  </div>
  @endif

  <p>
    <a class="btn btn-info" href="{{ route('projects.create') }}">Create Project</a>
  </p>
@endsection
