@extends('layouts.master')

@section('content')
    <h2>{{ $project->name }}</h2>

    @if ( !$project->tracks->count() )
        Your project has no tracks.
    @else
        <ul>
          @foreach( $project->tracks as $track )
              <li>
                  {!! Form::open(array('class' => 'form-inline', 'method' => 'DELETE', 'route' => array('projects.tasks.destroy', $project->slug, $track->slug))) !!}
                      <a href="{{ route('projects.tracks.show', [$project->slug, $track->slug]) }}">{{ $track->name }}</a>
                      (
                          {!! link_to_route('projects.tracks.edit', 'Edit', array($project->slug, $track->slug), array('class' => 'btn btn-info')) !!},

                          {!! Form::submit('Delete', array('class' => 'btn btn-danger')) !!}
                      )
                  {!! Form::close() !!}
              </li>
          @endforeach
        </ul>
    @endif

    <p>
        {!! link_to_route('projects.index', 'Back to Projects') !!} |
        {!! link_to_route('projects.tracks.create', 'Create Track', $project->slug) !!}
    </p>
@endsection
