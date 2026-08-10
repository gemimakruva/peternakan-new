@extends('layouts.dashboard')

@section('title', 'Gudang Pakan')

@section('content_header')
<x-page-header title="Gudang Pakan" :breadcrumbs="['Gudang Pakan' => '']" />
@endsection

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="mb-1">Modul Gudang Pakan</h5>
            <p class="text-muted mb-0">Silakan pilih menu di sidebar untuk memulai.</p>
        </div>
    </div>
</div>
@endsection
