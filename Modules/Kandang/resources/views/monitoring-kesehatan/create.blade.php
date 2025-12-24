@extends('layouts.dashboard')

@section('title', 'Form Monitoring Kesehatan')

@section('content_header')
    <div class="mb-4 text-center d-flex flex-column align-items-center" style="max-width: 1200px;'">
        <h2 class="h4 fw-bold text-dark">Form Monitoring Kesehatan</h2>
        <span class="text-muted mb-0" style="max-width: 600px;">
            Halaman ini digunakan Monitoring Kesehatan
        </span>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-9 mb-4">
            @include('components.form-alert')
            @include('kandang::monitoring-kesehatan._form')
        </div>
        <div class="col-md-4"></div>
    </div>
@endsection