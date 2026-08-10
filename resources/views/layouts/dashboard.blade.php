@extends('adminlte::page')

@section('adminlte_css_pre')
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
@stop

@push('css')
    @vite('resources/sass/dashboard.scss')
@endpush

@section('footer')
<x-bottom-nav />
@stop
