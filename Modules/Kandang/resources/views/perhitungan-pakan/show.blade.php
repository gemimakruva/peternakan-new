@extends('layouts.dashboard')

@section('title', 'Detail Perhitungan Pemberian Pakan')

@section('content_header')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <div class="d-flex align-items-center gap-1">
                <h1>Detail Perhitungan Pemberian Pakan</h1>
            </div>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Pemberian Pakan</li>
                <li class="breadcrumb-item"><a href="{{ route('perhitungan-pakan.index') }}">Perhitungan Pemberian Pakan</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </div>
    </div>
</div>
@endsection


@section('content')
<div class="mx-1200">
    <x-form-alert />

    <div class="row">
        <div class="col-12 col-lg-9">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Form Perhitungan Pakan</h2>
                </div>
                <div class="card-body">
                    @include('kandang::perhitungan-pakan._form', ['readonly' => true])
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Detail Perhitungan Pemberian Pakan</h2>
                </div>
                <div class="card-body p-0">
                    @include('kandang::perhitungan-pakan._form_perhitungan', ['readonly' => true])
                </div>
            </div>
        </div>
    
        <div class="col-12 col-lg-3">
            <div class="card sticy-form-action">
                <div class="card-header">
                    <h2 class="card-title">Aksi</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <a href="{{ route('perhitungan-pakan.index') }}" class="btn btn-outline-secondary flex-1">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection