@extends('layouts.app')

@section('title')
    Tags
@endsection

@section('content')
    @if ( !$tags->count() )
      <div class='alert alert-info'>
        There aren't any tags...yet.
      </div>
    @else
    <div class="list-group tag-list">
        @foreach( $tags as $tag )
            <a class="list-group-item">{{ $tag->name }}</a>
        @endforeach
    </div>
    @endif

    <p>
      <a class="btn btn-info" href="{{ route('tags.create') }}">Add a Tag</a>
    </p>
@endsection
