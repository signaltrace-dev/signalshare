@extends('layouts.master')

@section('content')
  <h2>Projects</h2>

  @if ( !$projects->count() )
    <div class='alert alert-info'>
      There aren't any projects...yet.
    </div>
  @else
    <ul>
        @foreach( $projects as $project )
            <li><a href="{{ route('projects.show', $project->slug) }}">{{ $project->name }}</a></li>
        @endforeach
    </ul>
  @endif
@endsection
