@extends('layouts.app')

@section('title')
    Needs
@endsection

@section('content')
    <div class="panel panel-brand">
      <div class="panel-heading">
        <h3 class="panel-title">All Needs</h3>
      </div>
      <div class="panel-body">
          @if ( !$needs->count() )
            <div class='alert alert-warning'>
              Nothing here.
            </div>
          @else
              @foreach( $needs as $need )
                  <div class="btn btn-info">{{ $need->name }}
                  <form class="form-inline" action='{{ route("needs.destroy", [$need->id] ) }}' method="POST">
                      {{ method_field('DELETE') }}
                      {{ csrf_field() }}
                      <button type="submit" class="link-delete"><i class="fa fa-times"></i></button></div>
                  </form>
              @endforeach
          @endif
      </div>
    </div>
    @include('needs.forms.add_need')
@endsection
