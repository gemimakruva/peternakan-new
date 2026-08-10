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

@push('js')
@auth
@unless(auth()->user()->has_seen_tour ?? false)
    @vite('resources/js/tour.js')
    <script>document.addEventListener('DOMContentLoaded', () => startTour('default'));</script>
@endunless
@endauth
@endpush
