@extends('layouts.app')

@section('title')
    {{ $profile->title() }}
@endsection

@section('pagenav')
    @include('people.navs.single', ['profile' => $profile])
@endsection

@section('content')

@endsection
