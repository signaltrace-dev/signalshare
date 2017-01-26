@extends('layouts.app')

@section('title')
    Taxonomies
@endsection

@section('content')
    <div class="panel panel-brand">
      <div class="panel-heading">
        <h3 class="panel-title">All Taxonomies</h3>
      </div>
      <div class="panel-body">
          @if ( !$taxonomies->count() )
            <div class='alert alert-warning'>
              Nothing here.
            </div>
          @else
              <div class="list-group">
                  @foreach( $taxonomies as $taxonomy )
                      <a href="{{ route('taxonomies.show', $taxonomy->slug) }}" class="list-group-item">
                          {{ $taxonomy->name }}
                      </a>
                  @endforeach
              </div>
          @endif
      </div>
    </div>
    @include('taxonomies.forms.add_edit')
@endsection
