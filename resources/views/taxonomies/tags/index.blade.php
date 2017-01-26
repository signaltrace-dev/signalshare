@extends('layouts.app')

@section('title')
    Tags
@endsection

@section('content')
    <div class="panel panel-brand">
      <div class="panel-heading">
        <h3 class="panel-title">All Tags</h3>
      </div>
      <div class="panel-body">
          @if ( !$tags->count() )
            <div class='alert alert-warning'>
              There aren't any tags...yet.
            </div>
          @else
              @foreach( $tags as $tag )
                  <div class="btn btn-info">{{ $tag->name }}
                  <form class="form-inline" action='{{ route("tags.destroy", [$tag->id] ) }}' method="POST">
                      {{ method_field('DELETE') }}
                      {{ csrf_field() }}
                      <button type="submit" class="link-delete"><i class="fa fa-times"></i></button></div>
                  </form>
              @endforeach
          @endif
      </div>
    </div>
    @include('taxonomies.tags.forms.add_tag', ['taxonomy' => $taxonomy])
@endsection
