@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content_header')
<x-page-header title="Dashboard" :breadcrumbs="['Dashboard' => '']" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="mb-1">Selamat datang, {{ Auth::user()->name }}</h5>
            <p class="text-muted mb-0">Sistem Pengelolaan Manajemen & Statistik Peternakan. Silakan pilih menu di sidebar untuk memulai.</p>
        </div>
    </div>
</div>
@endsection