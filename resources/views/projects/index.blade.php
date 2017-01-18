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
  <ul class="list-group">
      @foreach( $projects as $project )
          <li class="list-group-item">
              <form class='form-inline' method='POST', action="{{ route('projects.destroy', $project->slug) }}">
                {{ method_field('DELETE') }}
                {{ csrf_field() }}
                  <a href="{{ route('projects.show', $project->slug) }}">{{ $project->name }}</a>
                  <div class="btn-group pull-right">
                      <a class="btn btn-info" href="{{ route('projects.edit', $project->slug) }}">Edit</a>
                      <button type="submit" class="btn btn-danger">Delete</button>
                  </div>
              </form>
          </li>
      @endforeach
  </ul>
  @endif

  <p>
    <a class="btn btn-info" href="{{ route('projects.create') }}">Create Project</a>
  </p>
@endsection
