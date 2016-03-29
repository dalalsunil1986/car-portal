@extends('layouts.master')

@section('left-sidebar')
    @include('partials.sidebar-left')
    @include('partials.sidebar-left-mobile')
@stop

@section('content')
@stop

@section('right-sidebar')
    @include('partials.sidebar-right')
    @include('partials.sidebar-right-mobile')
@stop
