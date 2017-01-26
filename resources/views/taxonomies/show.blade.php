@extends('layouts.app')

@section('title')
    {{ $taxonomy->name }}
@endsection

@section('content')
    <a href="{{ route('taxonomies.tags.index', $taxonomy->slug) }}">Tags</a>
    <div class="panel panel-brand">
      <div class="panel-heading">
        <h3 class="panel-title">Settings</h3>
      </div>
      <div class="panel-body">

      </div>
    </div>
@endsection
